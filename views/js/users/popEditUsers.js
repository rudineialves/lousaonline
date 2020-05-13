

var openPopEditUsers;


(function($){

	var container;
	var dataHolder;
	var formHolder;
	var itemId    = '';
	var targetUrl = _FULLPATH +'/controllers/Users.php';
		
	function defineContainers(){
		container  = $("#mainPopEditUsers");
		dataHolder = container.find("#popHolder");
		formHolder = container.find("#formEditUsers");
	}

	/**
	 * ABRE O POP UP
	 */
	openPopEditUsers = function(pItemId){			
		clearPopEditUsers();
		container.parent().modal('show');

		if(pItemId){
			itemId = pItemId;
			loadEditUsers(pItemId);							
		}
		else {
			container.find(".modal-title").html('Adicionar novo item');
			
		}
	}
	
	
	/**
	 * CARREGA OS DADOS
	 */
	function loadEditUsers(pItemId){

		container.find('.loaderContent').fadeIn();
	
		$.ajax({
			type 	 : 'post',
			data 	 : { 
						'act' : 'Selecionar', 
                        'id'  : itemId
					   },
			url 	 : targetUrl,
			dataType : 'json',				
			success	 : function(data){
					
				container.find(".modal-title").html('Editar informações');
				
                container.find('#name').val(data.name);
                container.find('#lastname').val(data.lastname);
                container.find('#document').val(data.document);
                container.find('#sex').select2('val', data.sex);
                container.find('#datebirth').val(data.datebirth);
                container.find('#telephone').val(data.telephone);
                container.find('#cell').val(data.cell);
                container.find('#email').val(data.email);
                container.find('#login').val(data.login);
                container.find('#usertype').select2('val', data.usertype);
                container.find('#status').select2('val', data.status);

				container.find('.loaderContent').fadeOut();
			},
			error : function(){
				defaultNotify({message: 'Houve um erro de resposta', type: 'error'});
				container.find('.loaderContent').fadeOut();
			}
		}); 
	}	


	/**
	 * SALVA OS DADOS
	 */
	function saveEditUsers(){

		container.find('.loaderContent').fadeIn();		
	
		var options = {
			type 	: 'post',
			data 	: { 
						'act': 'Salvar', 
                        'id' : itemId
					  },
			url 	: targetUrl,	
			dataType: 'json',	
			success	: function(data){					
				container.find('.loaderContent').fadeOut();
				if(data.result == true){
					$(document).trigger('UsersUpdated', [data.item, itemId]);	
					defaultNotify({message:'As informações foram salvas com sucesso.', type: 'success'});				
					closePopEditUsers();
				}
				else {
					defaultNotify({message: data.result });
				}				
			},
			error : function(){
				defaultNotify({message:'Houve um erro de resposta.', type: 'error'});
				container.find('.loaderContent').fadeOut();
			}
		}; 

		formHolder.ajaxSubmit(options);		 
	}
	
	

	/**
	 * FECHA O POP UP
	 */
	function closePopEditUsers(){		
		clearPopEditUsers();
		container.parent().modal('hide');		
	};	


	/**
	 * LIMPA O POP UP
	 */
	function clearPopEditUsers(){
		itemId = '';
		document.forms["formEditUsers"].reset();
		container.find(".select2").select2("val", '');						
		container.find(".modal-title").html('&nbsp;');
		container.find('.loaderContent').hide();
				
	}


	/** 
	 * INIT
	 */
	$(function(){
		defineContainers();
		
		container.find('#closeEditUsersBtn , #cancelEditUsersBtn').click(function(e){
			e.preventDefault();
			closePopEditUsers();
		});	
		container.find('#saveEditUsersBtn').click(function(e){
			e.preventDefault();
			saveEditUsers();
		});
	});
	

})(jQuery);

