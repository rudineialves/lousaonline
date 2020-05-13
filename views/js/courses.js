
//var coursesUpdateImageListLine;

(function($){

	var coursesHolder; //container
	var coursesFilter; //form
	var coursesList;	  //list holder	
	var targetUrl = _FULLPATH +'/controllers/Courses.php';

	function defineContainers(){
		coursesHolder = $('#courses'); //container
		coursesFilter = coursesHolder.find('#courses-filter'); //form
		coursesList   = coursesHolder.find('#courses-data-table');	//list holder			
	}

	var coursesLock = false; //bloqueio para evitar chamadas duplicadas


	/**
	 * *******************************************************************************************
	 * LISTA COURSES
	 * *******************************************************************************************
	 */
	function getListCourses(){		

		if(coursesLock == false){

			coursesLock = true;
			coursesHolder.find(".data-loader").fadeIn();
			coursesFilter.find(".btn-src-send").prop("disabled", true);

			$.ajax({
				type: "post",
				data : {'act'             : 'Listar',
						'key'             : coursesFilter.find('#key').val(),
						'date_course_ini' : coursesFilter.find('#date_course_ini').val(),
						'date_course_fin' : coursesFilter.find('#date_course_fin').val(),
						'teacher_user_id' : coursesFilter.find('#teacher_user_id').val(),
						'student_user_id' : coursesFilter.find('#student_user_id').val(),
						'status'          : coursesFilter.find('#status').val()
					   },
				url: targetUrl,
				dataType: 'json',

				success: function(result) {	
					var dataLength = result.list.length;

					if(dataLength > 0){

						var content = '';						
						$.each(result.list, function(i, item){
							content += coursesString(item);

						});
						coursesList.find("tbody").html(content);	
					}

					coursesHolder.find(".data-loader").fadeOut();
					coursesFilter.find(".btn-src-send").prop("disabled", false);					
					coursesLock = false;
				},
				error: function() {					
					coursesHolder.find(".data-loader").fadeOut();
					coursesFilter.find(".btn-src-send").prop("disabled", false);	
					coursesLock = false;
				}
			}); 
		}
	}

	/**
	 * ******************************************************************************
	 * COURSES STRING
	 * monta o html
	 * ******************************************************************************
	 */
	function coursesString(data){

		/* monta o html e adiciona os dados */
		var item = '';
		item += '<tr id="item-'+data.id+'" class="data-item">';
		item +=     '<td class="a-middle"><a href="'+_FULLPATH+'/courses_description/'+data.id+'">'+data.name+'</a></td>';
        item +=     '<td class="a-middle text-center">'+data.dateCourse+'</td>';
        item +=     '<td class="a-middle text-center">'+data.hourInit+' / '+data.hourEnd+'</td>';
        item +=     '<td class="actions a-midle text-center">';
		item +=         '<a href="javascript:;" onclick="openPopInfoCourses('+data.id+')" class="tooltips" title="Mais informações"><i class="fa fa-info-circle"></i></a>';
		item +=         '<a href="javascript:;" onclick="openPopEditCourses('+data.id+')" class="tooltips" title="Editar"><i class="fa fa-pen"></i></a>';
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
	function coursesUpdateListLine(e, obj, pItemId){
		
		// se possuir id, atualiza a linha, senão adiciona o item no topo da lista
		if(pItemId){
			// se recebeu o objeto como parâmetro adiciona, senão busca os dados
			if(obj){
				coursesList.find("tbody #item-"+pItemId).replaceWith(coursesString(obj));
			}
			else {
				$.post(targetUrl, {'act': 'Selecionar', 'id': pItemId}, function(obj){
				 	coursesList.find("tbody #item-"+pItemId).replaceWith(coursesString(obj));
				}, 'json');
			}			
		}
		else {
			coursesList.find("tbody").prepend(coursesString(obj));
		}
	}
	
	


	/**
	 * ******************************************************************************
     * DELETE COURSES
     * ******************************************************************************
     */
	function deleteCourses(itemId){		

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
							coursesList.find("#item-"+itemId).fadeOut('fast',function(){$(this).remove()});
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
		clearCoursesList();
		getListCourses();
	}	


	/**
	 * ******************************************************************************
	 * RESET LIST
	 * limpa a lista e suas variáveis
	 * ******************************************************************************
	 */
	function clearCoursesList(){

		coursesLock = false;
		coursesList.find("tbody").html('');
	}


	/**
	 * ******************************************************************************
	 * INIT
	 * inicia as funções 
	 * ******************************************************************************
	 */
	$(function(){

		defineContainers();		

		getListCourses(); /* carrega a listagem ao iniciar a página */

		$(document).on('CoursesUpdated', coursesUpdateListLine);
		

		/** Eventos dos Filtros */
		coursesFilter.find(".select-field").change(onFieldChange);
		coursesFilter.find(".btn-src-send").click(onFieldChange);
		
		coursesList.on('click', '.item-delete', function(e){
			e.preventDefault();
			var itemId = $(this).attr('href');			
			deleteCourses(itemId);
		});

	});

})(jQuery);