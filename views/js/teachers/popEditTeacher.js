

var openPopEditTeacher;


(function($){

	var container;
	var dataHolder;
	var formHolder;
	var itemId    = '';
	var targetUrl = _FULLPATH +'/controllers/Teachers.php';
		
	function defineContainers(){
		container  = $("#mainPopEditTeacher");
		dataHolder = container.find("#popHolder");
		formHolder = container.find("#formEditTeacher");
	}

	/**
	 * ABRE O POP UP
	 */
	openPopEditTeacher = function(pItemId){			
		clearPopEditTeacher();
		container.parent().modal('show');

		if(pItemId){
			itemId = pItemId;
			loadEditTeacher(pItemId);							
		}
		else {
			container.find(".modal-title").html('Adicionar novo item');
			
		}
	}
	
	
	/**
	 * CARREGA OS DADOS
	 */
	function loadEditTeacher(pItemId){

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
                container.find('#sex').select2('val', data.sex);
                container.find('#datebirth').val(data.datebirth);
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
	function saveEditTeacher(){

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
					$(document).trigger('TeacherUpdated', [data.item, itemId]);	
					defaultNotify({message:'As informações foram salvas com sucesso.', type: 'success'});				
					closePopEditTeacher();
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
	function closePopEditTeacher(){		
		clearPopEditTeacher();
		container.parent().modal('hide');		
	};	


	/**
	 * LIMPA O POP UP
	 */
	function clearPopEditTeacher(){
		itemId = '';
		document.forms["formEditTeacher"].reset();
		container.find(".select2").select2("val", '');						
		container.find(".modal-title").html('&nbsp;');
		container.find('.loaderContent').hide();
				
	}


	/** 
	 * INIT
	 */
	$(function(){
		defineContainers();
		
		container.find('#closeEditTeacherBtn , #cancelEditTeacherBtn').click(function(e){
			e.preventDefault();
			closePopEditTeacher();
		});	
		container.find('#saveEditTeacherBtn').click(function(e){
			e.preventDefault();
			saveEditTeacher();
		});
	});
	

})(jQuery);

