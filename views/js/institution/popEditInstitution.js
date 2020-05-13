

var openPopEditInstitution;


(function($){

	var container;
	var dataHolder;
	var formHolder;
	var itemId    = '';
	var targetUrl = _FULLPATH +'/controllers/Institution.php';
		
	function defineContainers(){
		container  = $("#mainPopEditInstitution");
		dataHolder = container.find("#popHolder");
		formHolder = container.find("#formEditInstitution");
	}

	/**
	 * ABRE O POP UP
	 */
	openPopEditInstitution = function(pItemId){			
		clearPopEditInstitution();
		container.parent().modal('show');

		if(pItemId){
			itemId = pItemId;
			loadEditInstitution(pItemId);							
		}
		else {
			container.find(".modal-title").html('Adicionar novo item');
			
		}
	}
	
	
	/**
	 * CARREGA OS DADOS
	 */
	function loadEditInstitution(pItemId){

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
                container.find('#telephone').val(data.telephone);
                container.find('#cell').val(data.cell);
                container.find('#email').val(data.email);
                container.find('#login').val(data.login);
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
	function saveEditInstitution(){

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
					$(document).trigger('InstitutionUpdated', [data.item, itemId]);	
					defaultNotify({message:'As informações foram salvas com sucesso.', type: 'success'});				
					closePopEditInstitution();
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
	function closePopEditInstitution(){		
		clearPopEditInstitution();
		container.parent().modal('hide');		
	};	


	/**
	 * LIMPA O POP UP
	 */
	function clearPopEditInstitution(){
		itemId = '';
		document.forms["formEditInstitution"].reset();
		container.find(".select2").select2("val", '');						
		container.find(".modal-title").html('&nbsp;');
		container.find('.loaderContent').hide();
				
	}


	/** 
	 * INIT
	 */
	$(function(){
		defineContainers();
		
		container.find('#closeEditInstitutionBtn , #cancelEditInstitutionBtn').click(function(e){
			e.preventDefault();
			closePopEditInstitution();
		});	
		container.find('#saveEditInstitutionBtn').click(function(e){
			e.preventDefault();
			saveEditInstitution();
		});
	});
	

})(jQuery);

