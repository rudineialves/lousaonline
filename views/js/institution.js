
//var institutionUpdateImageListLine;

(function($){

	var institutionHolder; //container
	var institutionFilter; //form
	var institutionList;	  //list holder	
	var targetUrl = _FULLPATH +'/controllers/Institution.php';

	function defineContainers(){
		institutionHolder = $('#institution'); //container
		institutionFilter = institutionHolder.find('#institution-filter'); //form
		institutionList   = institutionHolder.find('#institution-data-table');	//list holder			
	}

	var institutionLock = false; //bloqueio para evitar chamadas duplicadas


	/**
	 * *******************************************************************************************
	 * LISTA USERS
	 * *******************************************************************************************
	 */
	function getListInstitution(){		

		if(institutionLock == false){

			institutionLock = true;
			institutionHolder.find(".data-loader").fadeIn();
			institutionFilter.find(".btn-src-send").prop("disabled", true);

			$.ajax({
				type: "post",
				data : {'act'              : 'Listar',	
						'key'              : institutionFilter.find('#key').val(),
						'registration_ini' : institutionFilter.find('#registration_ini').val(),
						'registration_fin' : institutionFilter.find('#registration_fin').val(),
						'usertype'         : institutionFilter.find('#usertype').val(),
						'status'           : institutionFilter.find('#status').val()
					   },
				url: targetUrl,
				dataType: 'json',
				success: function(result) {	

					var dataLength = result.list.length;			

					if(dataLength > 0){

						var content = '';						
						$.each(result.list, function(i, item){
							content += institutionString(item);							 
						});						
					}

					institutionList.find("tbody").html(content);

					institutionHolder.find(".data-loader").fadeOut();
					institutionFilter.find(".btn-src-send").prop("disabled", false);
					institutionLock = false;						
				},
				error: function() {					
					institutionHolder.find(".data-loader").fadeOut();
					institutionFilter.find(".btn-src-send").prop("disabled", false);	
					institutionLock = false;
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
	function institutionString(data){

		/* monta o html e adiciona os dados */
		var item = '';
		item += '<tr id="item-'+data.id+'" class="data-item">';
		item +=     '<td class="a-middle text-center">'+data.thumb+'</td>';
		item +=     '<td class="a-middle">'+data.name+' '+data.lastname+'</td>';
        item +=     '<td class="a-middle text-center">'+data.telephone+'</td>';
        item +=     '<td class="a-middle text-center">'+data.email+'</td>';
        item +=     '<td class="a-middle text-center">'+data.statusName+'</td>';
		item +=     '<td class="actions a-midle text-center">';
		item +=         '<a href="javascript:;" onclick="openPopInfoInstitution('+data.id+')" class="tooltips" title="Mais informações"><i class="fa fa-info-circle"></i></a>';
		item +=         '<a href="javascript:;" onclick="openPopEditInstitution('+data.id+')" class="tooltips" title="Editar"><i class="fa fa-pen"></i></a>';
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
	function institutionUpdateListLine(e, obj, pItemId){
		
		// se possuir id, atualiza a linha, senão adiciona o item no topo da lista
		if(pItemId){
			// se recebeu o objeto como parâmetro adiciona, senão busca os dados
			if(obj){
				institutionList.find("tbody #item-"+pItemId).replaceWith(institutionString(obj));
			}
			else {
				$.post(targetUrl, {'act': 'Selecionar', 'id': pItemId}, function(obj){
				 	institutionList.find("tbody #item-"+pItemId).replaceWith(institutionString(obj));
				}, 'json');
			}			
		}
		else {
			institutionList.find("tbody").prepend(institutionString(obj));
		}
	}
	
	


	/**
	 * ******************************************************************************
     * DELETE USERS
     * ******************************************************************************
     */
	function deleteInstitution(itemId){		

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
							institutionList.find("#item-"+itemId).fadeOut('fast',function(){$(this).remove()});
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
		clearInstitutionList();
		getListInstitution();
	}


	/**
	 * ******************************************************************************
	 * RESET LIST
	 * limpa a lista e suas variáveis
	 * ******************************************************************************
	 */
	function clearInstitutionList(){

		totalGeral = 0;
		institutionLock = false;
		institutionList.find("tbody").html('');
	}


	/**
	 * ******************************************************************************
	 * INIT
	 * inicia as funções 
	 * ******************************************************************************
	 */
	$(function(){

		defineContainers();		

		getListInstitution(); /* carrega a listagem ao iniciar a página */	
		
		$(document).on('InstitutionUpdated', institutionUpdateListLine);		

		/** Eventos dos Filtros */
		institutionFilter.find(".btn-src-send").click(onFieldChange);
		
		institutionList.on('click', '.item-delete', function(e){
			e.preventDefault();
			var itemId = $(this).attr('href');			
			deleteInstitution(itemId);
		});

	});

})(jQuery);