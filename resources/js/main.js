$(document).ready(function() {

	// Chosen Init
	$('select').chosen({no_results_text: 'Не удалось найти: '});
	
	// Variables
	var field = switchFields();
	var lastField = $('[data-step]').last().attr('data-step');

	// Events for Next button
	$('#submit').click(function(e) {
		e.preventDefault();

		// Last tab of form fields 
		if (field() >= lastField) {
			
			// Form validation
			if (validation()) {return false}

			// Send form
			sendForm();
		}	else {

			// Change cities
			changeCities();
			// Switch the form one step forward
			field(1);
		}

	});

	// Events for Back button
	$('#back').click(function() {
		field(-1);
	});

	// Refresh fields from the second tab when clicking on Region
	$('#region').chosen().change(function() {
		var fieldsTwo = $('.form__fields[data-step="2"] select');
		fieldsTwo.prop('selectedIndex', 0);
		fieldsTwo.trigger('chosen:updated');
	});

	// Refresh the field of regions when clicking on Сity
	$('#city').chosen().change(function() {
		changeDistricts();
	});

	// Validate input to the form name
	$('#username').on('input', function() {
		$(this).val($(this).val().replace(/[^а-яА-Яa-zA-Z ]/,''));
	});
});


// Form fields switcher
function switchFields(step) {
	var currentPosition = 1;
  return function(step = 0) {

  	// Hide field
		$('.form__fields[data-step=' + currentPosition + ']').removeClass('active');

		// Change current position
		currentPosition += step;

		// Hide/Show "Back" Button
		(currentPosition <= 1) ? $('#back').removeClass('active') : $('#back').addClass('active');

		// 
		(currentPosition == 2) ? $('#submit').text('Отправить') : $('#submit').text('Далее');

		// Display field
		$('.form__fields[data-step=' + currentPosition + ']').addClass('active');

		// Change step number
		$('.form__step').text(currentPosition);

		// Return new position
		return currentPosition;
  };
}


// Ajax change Cities
function changeCities() {
	$.ajax({
		url: '/index/getCities',
		type:'POST',
		data: $('.form').serialize(),
		dataType: 'JSON',
		success: function (data) {
			createOptions('#city', data);
		},
		error: function (xhr) {
			console.log(xhr);
		}
	});
}


// Ajax change Districts
function changeDistricts() {
	$.ajax({
		url: '/index/getDistricts',
		type:'POST',
		data: $('.form').serialize(),
		dataType: 'JSON',
		success: function (data) {
			createOptions('#district', data);
		},
		error: function (xhr) {
			console.log(xhr);
		}
	});
}


// Ajax send registration form
function sendForm() {
	$.ajax({
		url: '/index/registration',
		type:'POST',
		data: $('.form').serialize(),
		success: function (data) {
			$('.main').html(data);
		},
		error: function (xhr) {
			console.log(xhr);
		}
	});
}


// Create an option list from the received data
function createOptions(parent, data) {
	var parent = $(parent);
	parent.children().not(':first').remove();
	data.forEach(function(field) {
		parent.append('<option value="' + field['ter_id'] + '">' + field['ter_name'] + '</option>');
	});
	parent.trigger("chosen:updated");
}

// Валидация формы
function validation() {
	console.log('Validation');

	// Email Validation
	function isEmail(elem) {
		var regex = /^([a-zA-Z0-9_.+-])+\@(([a-zA-Z0-9-])+\.)+([a-zA-Z0-9]{2,4})+$/;
		regex.test(elem.val()) ? toggleValidStatus(elem, true) : toggleValidStatus(elem, false);
	}

	// Name Validation
	function isName(elem) {
		(elem.val().length < 255 && elem.val().length > 2) ? toggleValidStatus(elem, true) : toggleValidStatus(elem, false);
	}

	// Select Validation
	function isSelect(select_id) {
		elem = $(select_id + '_chosen li.result-selected');
		(elem.length > 0) ? toggleValidStatus($(select_id), true) : toggleValidStatus($(select_id), false);
	}

	function toggleValidStatus(elem, bool) {
		elem.attr('data-valid', bool);
	};

	// Init
	isEmail($('#email'));
	isName($('#username'));
	isSelect('#region');
	isSelect('#city');
	isSelect('#district');

	// Have invalid fields been found
	if ($('[data-valid="false"]').length > 0) {return true;}

}

