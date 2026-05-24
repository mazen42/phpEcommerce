let state = $("#state");
let city = $("#city");
let country = $("#country");

country.change(function () {
	let countryVal = $(this).val();
	console.log(countryVal);
	$.ajax({
		url: "https://countriesnow.space/api/v0.1/countries/states",
		method: "POST",
		dataType: "json",
		contentType: "application/json",

		data: JSON.stringify({
			country: countryVal,
		}),
		success: function (result) {
			console.log();
			let states = result.data.states;
			state.html("");
			city.html("");
			states.forEach((element) => {
				let option = `
					<option value="${element.name}">${element.name}</option>
				`;
				state.append(option);
			});
			loadCitySmoothly();
		},
	});
});
state.change(function () {
	let stateVal = $(this).val();
	let countryVal = country.val();
	console.log(stateVal);
	$.ajax({
		url: "https://countriesnow.space/api/v0.1/countries/state/cities",
		method: "POST",
		dataType: "json",
		contentType: "application/json",
		data: JSON.stringify({
			country: countryVal,
			state: stateVal,
		}),
		success: function (result) {
			console.log();
			let cities = result.data;
			city.html("");
			cities.forEach((element) => {
				let option = `
					<option value="${element}">${element}</option>
				`;
				city.append(option);
			});
		},
	});
});

function loadCitySmoothly() {
	let stateVal = state.val();
	let countryVal = country.val();
	console.log(stateVal);
	$.ajax({
		url: "https://countriesnow.space/api/v0.1/countries/state/cities",
		method: "POST",
		dataType: "json",
		contentType: "application/json",
		data: JSON.stringify({
			country: countryVal,
			state: stateVal,
		}),
		success: function (result) {
			console.log();
			let cities = result.data;
			city.html("");
			cities.forEach((element) => {
				let option = `
					<option value="${element}">${element}</option>
				`;
				city.append(option);
			});
		},
	});
}
