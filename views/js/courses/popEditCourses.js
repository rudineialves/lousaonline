

var openPopEditCourses;


(function($){

	var container;
	var dataHolder;
	var formHolder;
	var itemId    = '';
	var targetUrl = _FULLPATH +'/controllers/Courses.php';
		
	function defineContainers(){
		container  = $("#mainPopEditCourses");
		dataHolder = container.find("#popHolder");
		formHolder = container.find("#formEditCourses");
	}

	/**
	 * ABRE O POP UP
	 */
	openPopEditCourses = function(pItemId){			
		clearPopEditCourses();
		container.parent().modal('show');

		if(pItemId){
			itemId = pItemId;
			loadEditCourses(pItemId);							
		}
		else {
			container.find(".modal-title").html('Adicionar novo curso');
			
		}
	}
	
	
	/**
	 * CARREGA OS DADOS
	 */
	function loadEditCourses(pItemId){

		container.find('.loaderContent').fadeIn();
	
		$.ajax({
			type 	 : 'post',
			data 	 : { 
						'act'             : 'Selecionar', 
                        'id'              : itemId,
                        'teacher_user_id' : itemId,
                        'student_user_id' : itemId
					   },
			url 	 : targetUrl,
			dataType : 'json',				
			success	 : function(data){
					
				container.find(".modal-title").html('Editar informações');
				
                container.find('#name').val(data.name);
                container.find('#status').select2('val', data.status);
                container.find('#date_course').val(data.dateCourse);
                container.find('#hour_init').val(data.hourInit);
                container.find('#hour_end').val(data.hourEnd);
                container.find('#description').val(data.description);

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
	function saveEditCourses(){

		container.find('.loaderContent').fadeIn();		
	
		var options = {
			type 	: 'post',
			data 	: { 
						'act'             : 'Salvar', 
                        'id'              : itemId,
                        'teacher_user_id' : itemId,
                        'student_user_id' : itemId
					  },
			url 	: targetUrl,	
			dataType: 'json',	
			success	: function(data){					
				container.find('.loaderContent').fadeOut();
				if(data.result == true){
					$(document).trigger('CoursesUpdated', [data.item, itemId]);	
					defaultNotify({message:'As informações foram salvas com sucesso.', type: 'success'});				
					closePopEditCourses();
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
	function closePopEditCourses(){		
		clearPopEditCourses();
		container.parent().modal('hide');		
	};	


	/**
	 * LIMPA O POP UP
	 */
	function clearPopEditCourses(){
		itemId = '';
		document.forms["formEditCourses"].reset();
		container.find(".select2").select2("val", '');						
		container.find(".modal-title").html('&nbsp;');
		container.find('.loaderContent').hide();
				
	}


	/** 
	 * INIT
	 */
	$(function(){
		defineContainers();
		
		container.find('#closeEditCoursesBtn , #cancelEditCoursesBtn').click(function(e){
			e.preventDefault();
			closePopEditCourses();
		});	
		container.find('#saveEditCoursesBtn').click(function(e){
			e.preventDefault();
			saveEditCourses();
		});
	});
	

})(jQuery);

