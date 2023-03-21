/*FormWizard Init*/
"use strict";	
$(function(){
	/* Basic Wizard Init*/
	if($('#contact').length >0) {
		var form = $("#contact");
		form.validate({
			errorPlacement: function errorPlacement(error, element) { element.before(error); },
			rules: {
				confirm: {
					equalTo: "#password"
				}
			}
		});
		form.children("div").steps({
			headerTag: "h3",
			bodyTag: "section",
			transitionEffect: "fade",
			titleTemplate: "#title#", 
			onStepChanging: function (event, currentIndex, newIndex)
			{
				form.validate().settings.ignore = ":disabled,:hidden";
				return form.valid();
			},
			onFinishing: function (event, currentIndex)
			{
				form.validate().settings.ignore = ":disabled";
				return form.valid();
			},
			onFinished: function (event, currentIndex)
			{
				alert("Submitted!");
			}
		});
	}
	if($('#contact_v').length >0) {
		var form_v = $("#contact_v");
		form_v.validate({
			errorPlacement: function errorPlacement(error, element) { element.before(error); },
			rules: {
				confirm: {
					equalTo: "#password_1"
				}
			}
		});
		form_v.children("div").steps({
			headerTag: "h3",
			bodyTag: "section",
			transitionEffect: "fade",
			titleTemplate: "#title#", 
			stepsOrientation: "vertical",
			onStepChanging: function (event, currentIndex, newIndex)
			{
				form_v.validate().settings.ignore = ":disabled,:hidden";
				return form_v.valid();
			},
			onFinishing: function (event, currentIndex)
			{
				form_v.validate().settings.ignore = ":disabled";
				return form_v.valid();
			},
			onFinished: function (event, currentIndex)
			{
				alert("Submitted!");
			}
		});
	}
});
		