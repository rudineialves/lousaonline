
//var usersUpdateImageListLine;

(function($){

	var usersHolder; //container
	var usersFilter; //form
	var usersList;	  //list holder	
	var targetUrl = _FULLPATH +'/controllers/Users.php';

	function defineContainers(){
		usersHolder = $('#users'); //container
		usersFilter = usersHolder.find('#users-filter'); //form
		usersList   = usersHolder.find('#users-data-table');	//list holder			
	}

	var usersLock = false; //bloqueio para evitar chamadas duplicadas


	/**
	 * *******************************************************************************************
	 * LISTA USERS
	 * *******************************************************************************************
	 */
	function getListUsers(){		

		if(usersLock == false){

			usersLock = true;
			usersHolder.find(".data-loader").fadeIn();
			usersFilter.find(".btn-src-send").prop("disabled", true);

			$.ajax({
				type: "post",
				data : {'act'              : 'Listar',	
						'key'              : usersFilter.find('#key').val(),
						'registration_ini' : usersFilter.find('#registration_ini').val(),
						'registration_fin' : usersFilter.find('#registration_fin').val(),
						'usertype'         : usersFilter.find('#usertype').val(),
						'status'           : usersFilter.find('#status').val()
					   },
				url: targetUrl,
				dataType: 'json',
				success: function(result) {	

					var dataLength = result.list.length;			

					if(dataLength > 0){

						var content = '';						
						$.each(result.list, function(i, item){
							content += usersString(item);							 
						});						
					}

					usersList.find("tbody").html(content);

					usersHolder.find(".data-loader").fadeOut();
					usersFilter.find(".btn-src-send").prop("disabled", false);
					usersLock = false;						
				},
				error: function() {					
					usersHolder.find(".data-loader").fadeOut();
					usersFilter.find(".btn-src-send").prop("disabled", false);	
					usersLock = false;
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
	function usersString(data){

		/* monta o html e adiciona os dados */
		var item = '';
		item += '<tr id="item-'+data.id+'" class="data-item">';
		item +=     '<td class="a-middle text-center">'+data.thumb+'</td>';
		item +=     '<td class="a-middle">'+data.name+' '+data.lastname+'</td>';
        item +=     '<td class="a-middle text-center">'+data.telephone+'</td>';
        item +=     '<td class="a-middle text-center">'+data.email+'</td>';
        item +=     '<td class="a-middle text-center">'+data.usertypeName+'</td>';
        item +=     '<td class="a-middle text-center">'+data.statusName+'</td>';
		item +=     '<td class="actions a-midle text-center">';
		item +=         '<a href="javascript:;" onclick="openPopInfoUsers('+data.id+')" class="tooltips" title="Mais informações"><i class="fa fa-info-circle"></i></a>';
		item +=         '<a href="javascript:;" onclick="openPopEditUsers('+data.id+')" class="tooltips" title="Editar"><i class="fa fa-pen"></i></a>';
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
	function usersUpdateListLine(e, obj, pItemId){
		
		// se possuir id, atualiza a linha, senão adiciona o item no topo da lista
		if(pItemId){
			// se recebeu o objeto como parâmetro adiciona, senão busca os dados
			if(obj){
				usersList.find("tbody #item-"+pItemId).replaceWith(usersString(obj));
			}
			else {
				$.post(targetUrl, {'act': 'Selecionar', 'id': pItemId}, function(obj){
				 	usersList.find("tbody #item-"+pItemId).replaceWith(usersString(obj));
				}, 'json');
			}			
		}
		else {
			usersList.find("tbody").prepend(usersString(obj));
		}
	}
	
	


	/**
	 * ******************************************************************************
     * DELETE USERS
     * ******************************************************************************
     */
	function deleteUsers(itemId){		

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
							usersList.find("#item-"+itemId).fadeOut('fast',function(){$(this).remove()});
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
		clearUsersList();
		getListUsers();
	}


	/**
	 * ******************************************************************************
	 * RESET LIST
	 * limpa a lista e suas variáveis
	 * ******************************************************************************
	 */
	function clearUsersList(){

		totalGeral = 0;
		usersLock = false;
		usersList.find("tbody").html('');
	}


	/**
	 * ******************************************************************************
	 * INIT
	 * inicia as funções 
	 * ******************************************************************************
	 */
	$(function(){

		defineContainers();		

		getListUsers(); /* carrega a listagem ao iniciar a página */	
		
		$(document).on('UsersUpdated', usersUpdateListLine);		

		/** Eventos dos Filtros */
		usersFilter.find(".btn-src-send").click(onFieldChange);
		
		usersList.on('click', '.item-delete', function(e){
			e.preventDefault();
			var itemId = $(this).attr('href');			
			deleteUsers(itemId);
		});

	});

})(jQuery);