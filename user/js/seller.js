$(document).ready(function () {
    $("#menu-toggle").click(function (e) {
        e.preventDefault();
        $("#wrapper").toggleClass("toggled");
    });

    var ctxP = document.getElementById("pieChart").getContext('2d');
    var myPieChart = new Chart(ctxP, {
        type: 'pie',
        data: {
            labels: ["Total Order", "Customer Growth", "Total Revenue"],
            datasets: [{
                data: [81, 22, 62],
                backgroundColor: ["#F7464A", "#46BFBD", "#FDB45C"],
                hoverBackgroundColor: ["#FF5A5E", "#5AD3D1", "#FFC870"]
            }]
        },
        options: {
            responsive: true
        }
    });

    var ctxL = document.getElementById("lineChart").getContext('2d');
    var myLineChart = new Chart(ctxL, {
        type: 'line',
        data: {
            labels: ["Sunday", "Monday", "Tuesday", "Wednesday", "Thursday", "Friday", "Saturday"],
            datasets: [{
                label: "Orders",
                data: [65, 59, 80, 81, 56, 55, 40],
                backgroundColor: ['rgba(105, 0, 132, .2)'],
                borderColor: ['rgba(200, 99, 132, .7)'],
                borderWidth: 2
            }]
        },
        options: {
            responsive: true
        }
    });
});

$(document).ready(function() {
    $('#page-content').append($('#main-content'));
});