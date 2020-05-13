
//var studentUpdateImageListLine;

(function($){

	var studentHolder; //container
	var studentFilter; //form
	var studentList;	  //list holder	
	var targetUrl = _FULLPATH +'/controllers/Students.php';

	function defineContainers(){
		studentHolder = $('#student'); //container
		studentFilter = studentHolder.find('#student-filter'); //form
		studentList   = studentHolder.find('#student-data-table');	//list holder			
	}

	var studentLock = false; //bloqueio para evitar chamadas duplicadas


	/**
	 * *******************************************************************************************
	 * LISTA USERS
	 * *******************************************************************************************
	 */
	function getListStudent(){		

		if(studentLock == false){

			studentLock = true;
			studentHolder.find(".data-loader").fadeIn();
			studentFilter.find(".btn-src-send").prop("disabled", true);

			$.ajax({
				type: "post",
				data : {'act'              : 'Listar',	
						'key'              : studentFilter.find('#key').val(),
						'registration_ini' : studentFilter.find('#registration_ini').val(),
						'registration_fin' : studentFilter.find('#registration_fin').val(),
						'usertype'         : studentFilter.find('#usertype').val(),
						'status'           : studentFilter.find('#status').val()
					   },
				url: targetUrl,
				dataType: 'json',
				success: function(result) {	

					var dataLength = result.list.length;			

					if(dataLength > 0){

						var content = '';						
						$.each(result.list, function(i, item){
							content += studentString(item);							 
						});						
					}

					studentList.find("tbody").html(content);

					studentHolder.find(".data-loader").fadeOut();
					studentFilter.find(".btn-src-send").prop("disabled", false);
					studentLock = false;						
				},
				error: function() {					
					studentHolder.find(".data-loader").fadeOut();
					studentFilter.find(".btn-src-send").prop("disabled", false);	
					studentLock = false;
				}
			}); 
		}
	}

	/**
	 * ******************************************************************************
	 * USERS STRING
	 * monta o html
	 * ******************************************************************************
	 */
	function studentString(data){

		/* monta o html e adiciona os dados */
		var item = '';
		item += '<tr id="item-'+data.id+'" class="data-item">';
		item +=     '<td class="a-middle text-center">'+data.thumb+'</td>';
		item +=     '<td class="a-middle">'+data.name+' '+data.lastname+'</td>';
        item +=     '<td class="a-middle text-center">'+data.telephone+'</td>';
        item +=     '<td class="a-middle text-center">'+data.email+'</td>';
        item +=     '<td class="a-middle text-center">'+data.statusName+'</td>';
		item +=     '<td class="actions a-midle text-center">';
		item +=         '<a href="javascript:;" onclick="openPopInfoStudent('+data.id+')" class="tooltips" title="Mais informações"><i class="fa fa-info-circle"></i></a>';
		item +=         '<a href="javascript:;" onclick="openPopEditStudent('+data.id+')" class="tooltips" title="Editar"><i class="fa fa-pen"></i></a>';
		item +=         '<a href="'+data.id+'" class="item-delete tooltips" title="Excluir"><i class="fa fa-trash"></i></a>';
		item +=	    '</td>';
		item += '</tr>';

		return item;
	}


	/** 
	 * ******************************************************************************
	 * UPDATE LIST LINE
	 * Atualiza os dados de uma linha da lista
	 * ******************************************************************************
	 */
	function studentUpdateListLine(e, obj, pItemId){
		
		// se possuir id, atualiza a linha, senão adiciona o item no topo da lista
		if(pItemId){
			// se recebeu o objeto como parâmetro adiciona, senão busca os dados
			if(obj){
				studentList.find("tbody #item-"+pItemId).replaceWith(studentString(obj));
			}
			else {
				$.post(targetUrl, {'act': 'Selecionar', 'id': pItemId}, function(obj){
				 	studentList.find("tbody #item-"+pItemId).replaceWith(studentString(obj));
				}, 'json');
			}			
		}
		else {
			studentList.find("tbody").prepend(studentString(obj));
		}
	}
	
	


	/**
	 * ******************************************************************************
     * DELETE USERS
     * ******************************************************************************
     */
	function deleteStudent(itemId){		

		defaultConfirm({
			onConfirm: function(){		

				$.ajax({
					type: 'post',
					data: {
						'act' : 'Excluir',
						'id'  : itemId,
					},
					url: targetUrl,
					success: function(data){
						if(data == true){						
							studentList.find("#item-"+itemId).fadeOut('fast',function(){$(this).remove()});
						}
					}
				})
			}			
		})
	}


	/**
	 * ******************************************************************************
	 * FUNÇÃO ONCHANGE DOS INPUTS
	 * limpa o container, reseta as variáveis de chamada e 
	 * reinicia o getList
	 * ******************************************************************************
	 */
	function onFieldChange(){
		clearStudentList();
		getListStudent();
	}


	/**
	 * ******************************************************************************
	 * RESET LIST
	 * limpa a lista e suas variáveis
	 * ******************************************************************************
	 */
	function clearStudentList(){

		totalGeral = 0;
		studentLock = false;
		studentList.find("tbody").html('');
	}


	/**
	 * ******************************************************************************
	 * INIT
	 * inicia as funções 
	 * ******************************************************************************
	 */
	$(function(){

		defineContainers();		

		getListStudent(); /* carrega a listagem ao iniciar a página */	
		
		$(document).on('StudentUpdated', studentUpdateListLine);		

		/** Eventos dos Filtros */
		studentFilter.find(".btn-src-send").click(onFieldChange);
		
		studentList.on('click', '.item-delete', function(e){
			e.preventDefault();
			var itemId = $(this).attr('href');			
			deleteStudent(itemId);
		});

	});

})(jQuery);