

/**
 * Neste arquivo são configurados os plugins utilizados no sistema
 * são criados métodos padrões e os plugins são configurados dentro deles 
 * no caso de mudança ou atualização de algum plugin 
 * configurando-os nestes métodos servirá à todo o sistema sem a necessidade 
 * de sair "caçando" os códigos onde são utilizados
 */


/* ------------------------------------------------------------------------------------------------------- */

/* DATE PICKER BR - utilizando Bootstrap Datepicker */

/* ------------------------------------------------------------------------------------------------------- */
$.fn.datepickerDefault = function(){

	return this.each(function(){
	
		$(this).attr('autocomplete','off');
		
		$(this).datepicker({
		    format: 'dd/mm/yyyy',
		    language: 'pt-BR'
		});

	});
};

/* ------------------------------------------------------------------------------------------------------- */
/* DEFAULT NOTIFY */
/* utilizando o plugin toast-r */
/* ------------------------------------------------------------------------------------------------------- */
defaultNotify = function(options){	
	
	//opções padrão deste método
	var settings = $.extend({
		title   : '',
		message : '',
		type    : 'info', //info, warning, success, error
		icon    : ''		
	}, options);

	//configurando o plugin convertendo as opções padrão do método 
	//para as opções padrão do plugin
	toastr.options.closeButton = true;
	toastr[settings.type](settings.message, settings.title);
}



/* ------------------------------------------------------------------------------------------------------- */
/* DEFAULT CONFIRM - Custom Confirm
/* utilizando jquery confirm
/* https://craftpip.github.io/jquery-confirm/
/* ------------------------------------------------------------------------------------------------------- */
defaultConfirm = function(options){	
	
	var settings = $.extend({
		title     : 'Confirme!',
		icon      : 'fa fa-question-circle',
		message   : "Você tem certeza que deseja excluir este item?",
		onCancel  : function(){},
		onConfirm : function(){}
	}, options);

	
	$.confirm({
	    title: (settings.icon ? '<i class="'+settings.icon+'"></i> ' : '')+settings.title,
	    content: settings.message,
	    buttons: {
	        confirm: {
	        	text: '&nbsp;&nbsp; Sim &nbsp;&nbsp;',
            	btnClass: 'btn-primary',
            	action: settings.onConfirm
	        },
	        cancel: {
	        	text: '&nbsp;&nbsp; Não &nbsp;&nbsp;',
	            btnClass: 'btn-default',
	            action: settings.onCancel
	        },
	    }
	});
}