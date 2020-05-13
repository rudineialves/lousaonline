

var openPopInfoUsers;

(function($){

	var container  = $("#popInfoUsers");
	var dataHolder = container.find("#popHolder");
	

	/**
	 * ABRE O POP UP
	 */
	openPopInfoUsers = function (itemId){			
		clearPopInfoUsers();

		container.modal('show'); 
		loadInfoUsers(itemId);	
	}
	
	
	/**
	 * CARREGA OS DADOS
	 */
	function loadInfoUsers(itemId){

		container.find('.loaderContent').fadeIn();
	
		$.ajax({
			type 	: 'post',
			data 	: { 
						'act' : 'Selecionar',
						'id'  : itemId
					},
			url 	: _FULLPATH +'/controllers/Users.php',
			dataType: 'json',				
			success	: function(data){
				
				container.find(".modal-title").html('Informações de usuários');

				var item = '';
				
                item += data.id ? '<p class="item-group"><strong>ID: #</strong><span>'+ data.id +'</span></p>' : '';
                item += data.name ? '<p class="item-group"><strong>Nome:</strong> <span>'+ data.name +(data.lastname ? ' '+ data.lastname : '')+'</span></p>' : '';
                item += data.usertypeName ? '<p class="item-group"><strong>Tipo:</strong> <span>'+ data.usertypeName +'</span></p>' : '';
                item += data.statusName ? '<p class="item-group"><strong>Status:</strong> <span>'+ data.statusName +'</span></p>' : '';	
                item += data.registration ? '<p class="item-group"><strong>Data do cadastro:</strong> <span>'+ data.registration +'</span></p>' : '';
                item += data.lastupdate ? '<p class="item-group"><strong>Última alteração em:</strong> <span>'+ data.lastupdate +'</span></p>' : '';
                item += data.lastaccess ? '<p class="item-group"><strong>Último acesso em:</strong> <span>'+ data.lastaccess +'</span></p>' : '';
                item += data.document ? '<p class="item-group"><strong>CPF:</strong> <span>'+ data.document +'</span></p>' : '';
                item += data.sex ? '<p class="item-group"><strong>Sexo:</strong> <span>'+ data.sex +'</span></p>' : '';
                item += data.datebirth ? '<p class="item-group"><strong>Data nascimento:</strong> <span>'+ data.datebirth +'</span></p>' : '';
                item += data.telephone ? '<p class="item-group"><strong>Telefone:</strong> <span>'+ data.telephone +'</span></p>' : '';
                item += data.cell ? '<p class="item-group"><strong>Celular:</strong> <span>'+ data.cell +'</span></p>' : '';
                item += data.email ? '<p class="item-group"><strong>Email:</strong> <span>'+ data.email +'</span></p>' : '';
                item += data.login ? '<p class="item-group"><strong>Login:</strong> <span>'+ data.login +'</span></p>' : '';
                		

				dataHolder.html(item);
					
				container.find('.loaderContent').fadeOut();
			},
			error : function(){
				defaultNotify({message: 'Houve um erro de resposta', type: 'error'});
				container.find('.loaderContent').fadeOut();
			}
		}); 
	}	


	
	/**
	 * FECHA O POP UP
	 */
	function closePopInfoUsers(){		
		clearPopInfoUsers();
		$("#popInfoUsers").modal('hide');		
	};	


	/**
	 * LIMPA O POP UP
	 */
	function clearPopInfoUsers(){
		container.find(".modal-title").html('&nbsp;');
		dataHolder.html('');
	}



	/** INIT */
	$(function(){
		container.find('#closeInfoUsersBtn, #cancelInfoUsersBtn').click(closePopInfoUsers);
	});
	

})(jQuery);

