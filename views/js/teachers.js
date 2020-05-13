
//var teacherUpdateImageListLine;

(function($){

	var teacherHolder; //container
	var teacherFilter; //form
	var teacherList;	  //list holder	
	var targetUrl = _FULLPATH +'/controllers/Teachers.php';

	function defineContainers(){
		teacherHolder = $('#teacher'); //container
		teacherFilter = teacherHolder.find('#teacher-filter'); //form
		teacherList   = teacherHolder.find('#teacher-data-table');	//list holder			
	}

	var teacherLock = false; //bloqueio para evitar chamadas duplicadas


	/**
	 * *******************************************************************************************
	 * LISTA USERS
	 * *******************************************************************************************
	 */
	function getListTeacher(){		

		if(teacherLock == false){

			teacherLock = true;
			teacherHolder.find(".data-loader").fadeIn();
			teacherFilter.find(".btn-src-send").prop("disabled", true);

			$.ajax({
				type: "post",
				data : {'act'              : 'Listar',	
						'key'              : teacherFilter.find('#key').val(),
						'registration_ini' : teacherFilter.find('#registration_ini').val(),
						'registration_fin' : teacherFilter.find('#registration_fin').val(),
						'usertype'         : teacherFilter.find('#usertype').val(),
						'status'           : teacherFilter.find('#status').val()
					   },
				url: targetUrl,
				dataType: 'json',
				success: function(result) {	

					var dataLength = result.list.length;			

					if(dataLength > 0){

						var content = '';						
						$.each(result.list, function(i, item){
							content += teacherString(item);							 
						});						
					}

					teacherList.find("tbody").html(content);

					teacherHolder.find(".data-loader").fadeOut();
					teacherFilter.find(".btn-src-send").prop("disabled", false);
					teacherLock = false;						
				},
				error: function() {					
					teacherHolder.find(".data-loader").fadeOut();
					teacherFilter.find(".btn-src-send").prop("disabled", false);	
					teacherLock = false;
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
	function teacherString(data){

		/* monta o html e adiciona os dados */
		var item = '';
		item += '<tr id="item-'+data.id+'" class="data-item">';
		item +=     '<td class="a-middle text-center">'+data.thumb+'</td>';
		item +=     '<td class="a-middle">'+data.name+' '+data.lastname+'</td>';
        item +=     '<td class="a-middle text-center">'+data.telephone+'</td>';
        item +=     '<td class="a-middle text-center">'+data.email+'</td>';
        item +=     '<td class="a-middle text-center">'+data.institutionName+'</td>';
        item +=     '<td class="a-middle text-center">'+data.statusName+'</td>';
		item +=     '<td class="actions a-midle text-center">';
		item +=         '<a href="javascript:;" onclick="openPopInfoTeacher('+data.id+')" class="tooltips" title="Mais informações"><i class="fa fa-info-circle"></i></a>';
		item +=         '<a href="javascript:;" onclick="openPopEditTeacher('+data.id+')" class="tooltips" title="Editar"><i class="fa fa-pen"></i></a>';
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
	function teacherUpdateListLine(e, obj, pItemId){
		
		// se possuir id, atualiza a linha, senão adiciona o item no topo da lista
		if(pItemId){
			// se recebeu o objeto como parâmetro adiciona, senão busca os dados
			if(obj){
				teacherList.find("tbody #item-"+pItemId).replaceWith(teacherString(obj));
			}
			else {
				$.post(targetUrl, {'act': 'Selecionar', 'id': pItemId}, function(obj){
				 	teacherList.find("tbody #item-"+pItemId).replaceWith(teacherString(obj));
				}, 'json');
			}			
		}
		else {
			teacherList.find("tbody").prepend(teacherString(obj));
		}
	}
	
	


	/**
	 * ******************************************************************************
     * DELETE USERS
     * ******************************************************************************
     */
	function deleteTeacher(itemId){		

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
							teacherList.find("#item-"+itemId).fadeOut('fast',function(){$(this).remove()});
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
		clearTeacherList();
		getListTeacher();
	}


	/**
	 * ******************************************************************************
	 * RESET LIST
	 * limpa a lista e suas variáveis
	 * ******************************************************************************
	 */
	function clearTeacherList(){

		totalGeral = 0;
		teacherLock = false;
		teacherList.find("tbody").html('');
	}


	/**
	 * ******************************************************************************
	 * INIT
	 * inicia as funções 
	 * ******************************************************************************
	 */
	$(function(){

		defineContainers();		

		getListTeacher(); /* carrega a listagem ao iniciar a página */	
		
		$(document).on('TeacherUpdated', teacherUpdateListLine);		

		/** Eventos dos Filtros */
		teacherFilter.find(".btn-src-send").click(onFieldChange);
		
		teacherList.on('click', '.item-delete', function(e){
			e.preventDefault();
			var itemId = $(this).attr('href');			
			deleteTeacher(itemId);
		});

	});

})(jQuery);