$(document).ready(function(){



	$( "#evalPays" ).click(function(e) {
		e.preventDefault();
		$("#cnt2").empty();
		var selectPays=$( "#pays" ).val();
		//alert(selectPays);
		$("#cnt2").append('<canvas id="'+selectPays+'"></canvas>');
		var selectPays=$( "#pays" ).val();
		//alert(selectPays);
		$.ajax({
		url: "./apic/"+selectPays,
		method: "GET",
		success: function(data) {
			console.log(data);
			var minCout = [];
			var moyCout = [];
			var maxCout = [];
			var annee = [];
			var pays = [];

			for(var i in data) {
				annee.push(data[i].dyear);
				minCout.push(data[i].minCout);
				moyCout.push(data[i].moyCout);
				maxCout.push(data[i].maxCout);
			}

			var chartdata = {
				labels: annee,
				datasets : [
					{
						label: 'min',
						backgroundColor: "rgba(59, 89, 152, 0.75)",
						borderColor: "rgba(59, 89, 152, 1)",
						pointHoverBackgroundColor: "rgba(59, 89, 152, 1)",
						pointHoverBorderColor: "rgba(59, 89, 152, 1)",
						data: minCout
					},
					{
						label: 'moy',
						backgroundColor: "rgba(29, 202, 255, 0.75)",
						borderColor: "rgba(29, 202, 255, 1)",
						pointHoverBackgroundColor: "rgba(29, 202, 255, 1)",
						pointHoverBorderColor: "rgba(29, 202, 255, 1)",
						data: moyCout
					},
					{
						label: 'max',
					backgroundColor: "rgba(211, 72, 54, 0.75)",
						borderColor: "rgba(211, 72, 54, 1)",
						pointHoverBackgroundColor: "rgba(211, 72, 54, 1)",
						pointHoverBorderColor: "rgba(211, 72, 54, 1)",
						data: maxCout
					}
				]
			};

			var ctx = $("#"+selectPays);
				if (maxCout == '') {

				//	$('#NoData').modal('show')
		alert('Le pays sélectionné ne dispose pas encore de données suffisantes pour effectuer ses Statistiques. Merci de rééssayer plus tard');
			}else{
				
				$( "#titre" ).text(selectPays);

			var barGraph = new Chart(ctx, {
				type: 'bar',
				data: chartdata,
    options: {
    	 title:{
              display:true,
              text:"Statistiques de consommations ( "+selectPays+")"
          },
        scales: {
            yAxes: [{
            	 scaleLabel: {
        display: true,
        labelString: 'Coût en $'
      },

                ticks: {
                    // Create scientific notation labels
                   
               min: 0,
        stepSize: 100,
        max: 1200
                }
            }]
        }
    }
			});

				}
			
		},
		error: function(data) {
			console.log(data);
		}
	});
 
});
	$.ajax({
		url: "./api",
		method: "GET",
		success: function(data) {
			console.log(data);
			var minCout = [];
			var moyCout = [];
			var maxCout = [];
			var pays = [];
			var cout = [];

			for(var i in data) {
				pays.push(data[i].country);
				minCout.push(data[i].minCout);
				moyCout.push(data[i].moyCout);
				maxCout.push(data[i].maxCout);
				cout.push(data[i].cout);
			}

			var chartdata = {
				labels: pays,
				datasets : [
					{
						label: 'min',
						backgroundColor: "rgba(59, 89, 152, 0.75)",
						borderColor: "rgba(59, 89, 152, 1)",
						pointHoverBackgroundColor: "rgba(59, 89, 152, 1)",
						pointHoverBorderColor: "rgba(59, 89, 152, 1)",
						data: minCout
					},
					{
						label: 'moy',
						backgroundColor: "rgba(29, 202, 255, 0.75)",
						borderColor: "rgba(29, 202, 255, 1)",
						pointHoverBackgroundColor: "rgba(29, 202, 255, 1)",
						pointHoverBorderColor: "rgba(29, 202, 255, 1)",
						data: moyCout
					},
					{
						label: 'max',
					backgroundColor: "rgba(211, 72, 54, 0.75)",
						borderColor: "rgba(211, 72, 54, 1)",
						pointHoverBackgroundColor: "rgba(211, 72, 54, 1)",
						pointHoverBorderColor: "rgba(211, 72, 54, 1)",
						data: maxCout
					}
				]
			};

			var ctx = $("#mycanvas");

			var barGraph = new Chart(ctx, {
				type: 'bar',
				data: chartdata,
    options: {
    	 title:{
              display:true,
              text:"Statistiques de consommations globale"
          },
        scales: {
            yAxes: [{
            	 scaleLabel: {
        display: true,
        labelString: 'Coût en $'
      },

                ticks: {
                    // Create scientific notation labels
                   
               min: 0,
        stepSize: 100,
        max: 1200
                }
            }]
        }
    }
			});
		},
		error: function(data) {
			console.log(data);
		}
	});
});