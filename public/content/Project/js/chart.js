$(document).ready(function() {


    var cts = $("#competencestar");

    var $window = $(this);
    var pointRadius = 7;
    var pointHoverRadius = 6;
    var hitRadius = 6;

    var tickFontSize = 28;
    var pointLabelFontSize = 25;
    var titleFontSize = 60;
    var legendFontSize = 35;

    var tooltipTitleFontSize = 30;
    var tooltipbodyFontSize = 30;
    var tooltipfooterFontSize = 30;

    var graphdata = [];

    $.ajax({
        url:        rootPath + '/ajax/loadcompetencestar',
        dataType:   'json',
        type:       'GET',
        async:      false,
        data: {id: $('#studentid').val()},

        success: function(data) {
            graphdata = [data.sdov, data.lbap, data.lbao, data.brv, data.rep, data.top, data.op, data.lpo, data.ep]
        }
    });

    function checkWidth() {

        var windowWidth = $window.width;

        if (windowWidth < 1500) {

            pointRadius = 4;
            pointHoverRadius = 3;
            hitRadius = 3;

            tickFontSize = 20;
            pointLabelFontSize = 20;
            titleFontSize = 40;
            legendFontSize = 25;

            tooltipTitleFontSize = 20;
            tooltipbodyFontSize = 20;
            tooltipfooterFontSize = 20;
        }

        var competenceStar = new Chart(cts, {
            type: 'radar',
            data: {
                labels: ["Stelt de opdracht vast", "Levert bijdrage aan projectplan", "Levert bijdrage aan ontwerp",
                    "Bereidt realisatie voor", "Realiseert een product", "Test ontwikkelde product",
                    "Optimaliseert product", "Levert product op", "Evalueert product"],
                datasets: [{
                    label: "Mijn niveau",
                    backgroundColor: "rgba(255,99,132,0.2)",
                    borderColor: "rgba(255,99,132,1)",
                    pointBackgroundColor: "rgba(255,99,132,1)",
                    pointBorderColor: "#fff",
                    pointHoverBackgroundColor: "#fff",
                    pointHoverBorderColor: "rgba(255,99,132,1)",
                    pointRadius: pointRadius,
                    pointHoverRadius: pointHoverRadius,
                    hitRadius: hitRadius,
                    data: graphdata
                }, {
                    label: "School niveau",
                    backgroundColor: "rgba(179,181,198,0.2)",
                    borderColor: "rgba(179,181,198,1)",
                    pointBackgroundColor: "rgba(179,181,198,1)",
                    pointBorderColor: "#fff",
                    pointHoverBackgroundColor: "#fff",
                    pointHoverBorderColor: "rgba(179,181,198,1)",
                    pointRadius: pointRadius,
                    pointHoverRadius: pointHoverRadius,
                    hitRadius: hitRadius,
                    data: [60, 60, 60, 60, 60, 60, 60, 60, 60]
                }]
            },
            options: {
                scale: {
                    reverse: false,
                    ticks: {
                        beginAtZero: false,
                        fontSize: tickFontSize,
                        min: 1,
                        max: 100,
                        maxTicksLimit: 10
                    },
                    pointLabels: {
                        fontSize: pointLabelFontSize,
                        fontStyle: 'bold'
                    }
                },

                title: {
                    display: true,
                    position: 'top',
                    text: 'Voortgang',
                    fontSize: titleFontSize
                },

                legend:{
                    display: true,
                    position: 'bottom',
                    labels:{
                        fontSize: legendFontSize
                    }
                },

                tooltips: {
                    enabled: true,
                    titleFontSize: tooltipTitleFontSize,
                    bodyFontSize: tooltipbodyFontSize,
                    footerFontSize: tooltipfooterFontSize,
                    xPadding: 10,
                    yPadding: 10

                },

                responsive: true,
                maintainAspectRatio: true
            }
        });
    }

    checkWidth();

    $(window).resize(checkWidth);
});