

var openPopInfoCourses;

(function($){

	var container  = $("#popInfoCourses");
	var dataHolder = container.find("#popHolder");
	

	/**
	 * ABRE O POP UP
	 */
	openPopInfoCourses = function (itemId){			
		clearPopInfoCourses();

		container.modal('show'); 
		loadInfoCourses(itemId);	
	}
	
	
	/**
	 * CARREGA OS DADOS
	 */
	function loadInfoCourses(itemId){

		container.find('.loaderContent').fadeIn();
	
		$.ajax({
			type 	: 'post',
			data 	: { 
						'act' : 'Selecionar',
						'id'  : itemId
					},
			url 	: _FULLPATH +'/controllers/Courses.php',
			dataType: 'json',				
			success	: function(data){
				
				container.find(".modal-title").html('Informações de courses');

				var item = '';				
				
                item += data.id ? '<p class="item-group"><strong>Id do curso:</strong> <span>'+ data.id +'</span></p>' : '';
                item += data.name ? '<p class="item-group"><strong>Nome:</strong> <span>'+ data.name +'</span></p>' : '';
                item += data.dateCreated ? '<p class="item-group"><strong>Criado em:</strong> <span>'+ data.dateCreated +'</span></p>' : '';
                item += data.dateCourse ? '<p class="item-group"><strong>Data do curso:</strong> <span>'+ data.dateCourse +'</span></p>' : '';
                item += data.hourInit ? '<p class="item-group"><strong>Horário:</strong> <span>'+data.hourInit+' / '+data.hourEnd+'</span></p>' : '';
                item += data.status ? '<p class="item-group"><strong>Status:</strong> <span>'+ data.status +'</span></p>' : '';
                item += data.description ? '<p class="item-group"><strong>Descrição do Curso:</strong> <span>'+ data.description +'</span></p>' : '';			

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
	function closePopInfoCourses(){		
		clearPopInfoCourses();
		$("#popInfoCourses").modal('hide');		
	};	


	/**
	 * LIMPA O POP UP
	 */
	function clearPopInfoCourses(){
		container.find(".modal-title").html('&nbsp;');
		dataHolder.html('');
	}



	/** INIT */
	$(function(){
		container.find('#closeInfoCoursesBtn, #cancelInfoCoursesBtn').click(closePopInfoCourses);
	});
	

})(jQuery);

