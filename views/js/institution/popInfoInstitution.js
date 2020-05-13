

var openPopInfoInstitution;

(function($){

	var container  = $("#popInfoInstitution");
	var dataHolder = container.find("#popHolder");
	

	/**
	 * ABRE O POP UP
	 */
	openPopInfoInstitution = function (itemId){			
		clearPopInfoInstitution();

		container.modal('show'); 
		loadInfoInstitution(itemId);	
	}
	
	
	/**
	 * CARREGA OS DADOS
	 */
	function loadInfoInstitution(itemId){

		container.find('.loaderContent').fadeIn();
	
		$.ajax({
			type 	: 'post',
			data 	: { 
						'act' : 'Selecionar',
						'id'  : itemId
					},
			url 	: _FULLPATH +'/controllers/Institution.php',
			dataType: 'json',				
			success	: function(data){
				
				container.find(".modal-title").html('Informações da instituição');

				var item = '';
				
                item += data.id ? '<p class="item-group"><strong>ID: #</strong><span>'+ data.id +'</span></p>' : '';
                item += data.name ? '<p class="item-group"><strong>Nome:</strong> <span>'+ data.name +(data.lastname ? ' '+ data.lastname : '')+'</span></p>' : '';
                item += data.usertypeName ? '<p class="item-group"><strong>Tipo:</strong> <span>'+ data.usertypeName +'</span></p>' : '';
                item += data.statusName ? '<p class="item-group"><strong>Status:</strong> <span>'+ data.statusName +'</span></p>' : '';	
                item += data.registration ? '<p class="item-group"><strong>Data do cadastro:</strong> <span>'+ data.registration +'</span></p>' : '';
                item += data.lastupdate ? '<p class="item-group"><strong>Última alteração em:</strong> <span>'+ data.lastupdate +'</span></p>' : '';
                item += data.lastaccess ? '<p class="item-group"><strong>Último acesso em:</strong> <span>'+ data.lastaccess +'</span></p>' : '';
                item += data.document ? '<p class="item-group"><strong>CNPJ:</strong> <span>'+ data.document +'</span></p>' : '';
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
	function closePopInfoInstitution(){		
		clearPopInfoInstitution();
		$("#popInfoInstitution").modal('hide');		
	};	


	/**
	 * LIMPA O POP UP
	 */
	function clearPopInfoInstitution(){
		container.find(".modal-title").html('&nbsp;');
		dataHolder.html('');
	}



	/** INIT */
	$(function(){
		container.find('#closeInfoInstitutionBtn, #cancelInfoInstitutionBtn').click(closePopInfoInstitution);
	});
	

})(jQuery);

