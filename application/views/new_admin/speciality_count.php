<!DOCTYPE html>
<html lang="en">
  <head>
    <?php include_once( 'includes/head.php'); ?>
  </head>

  <body class="nav-md">
    <div class="container body">
      <div class="main_container">
        <?php include_once( 'includes/sidebar.php'); ?>
        <?php include_once('includes/topbar.php'); ?>
        
        <div class="right_col" role="main" style="min-height: 3788px;">
          <!-- Dynamic Content will come here. -->
          <div id="echart_pie" style="height:350px;"></div>
        </div>

        <!-- footer content -->
        <footer>
          <div class="pull-right">
            Abbott - App Admin Dashboard by <a href="http://kreaserv.com">Kreaserv</a>
          </div>
          <div class="clearfix"></div>
        </footer>
        <!-- /footer content -->
      </div>
    </div>
    <?php include_once( 'includes/footer.php'); ?>
    <!-- ECharts -->
    <script src="<?=base_url()?>assets/new_admin/vendors/echarts/dist/echarts.min.js"></script>
    <script src="<?=base_url()?>assets/new_admin/vendors/echarts/map/js/world.js"></script>
    <script>
		var theme = {
		    color: [
		        '#26B99A', '#34495E', '#BDC3C7', '#3498DB',
		        '#9B59B6', '#8abb6f', '#759c6a', '#bfd3b7'
		    ],
		
		    title: {
		        itemGap: 8,
		        textStyle: {
		            fontWeight: 'normal',
		            color: '#408829'
		        }
		    },
		
		    dataRange: {
		        color: ['#1f610a', '#97b58d']
		    },
		
		    toolbox: {
		        color: ['#408829', '#408829', '#408829', '#408829']
		    },
		
		    tooltip: {
		        backgroundColor: 'rgba(0,0,0,0.5)',
		        axisPointer: {
		            type: 'line',
		            lineStyle: {
		                color: '#408829',
		                type: 'dashed'
		            },
		            crossStyle: {
		                color: '#408829'
		            },
		            shadowStyle: {
		                color: 'rgba(200,200,200,0.3)'
		            }
		        }
		    },
		
		    dataZoom: {
		        dataBackgroundColor: '#eee',
		        fillerColor: 'rgba(64,136,41,0.2)',
		        handleColor: '#408829'
		    },
		    grid: {
		        borderWidth: 0
		    },
		
		    categoryAxis: {
		        axisLine: {
		            lineStyle: {
		                color: '#408829'
		            }
		        },
		        splitLine: {
		            lineStyle: {
		                color: ['#eee']
		            }
		        }
		    },
		
		    valueAxis: {
		        axisLine: {
		            lineStyle: {
		                color: '#408829'
		            }
		        },
		        splitArea: {
		            show: true,
		            areaStyle: {
		                color: ['rgba(250,250,250,0.1)', 'rgba(200,200,200,0.1)']
		            }
		        },
		        splitLine: {
		            lineStyle: {
		                color: ['#eee']
		            }
		        }
		    },
		    timeline: {
		        lineStyle: {
		            color: '#408829'
		        },
		        controlStyle: {
		            normal: {
		                color: '#408829'
		            },
		            emphasis: {
		                color: '#408829'
		            }
		        }
		    },
		
		    k: {
		        itemStyle: {
		            normal: {
		                color: '#68a54a',
		                color0: '#a9cba2',
		                lineStyle: {
		                    width: 1,
		                    color: '#408829',
		                    color0: '#86b379'
		                }
		            }
		        }
		    },
		    map: {
		        itemStyle: {
		            normal: {
		                areaStyle: {
		                    color: '#ddd'
		                },
		                label: {
		                    textStyle: {
		                        color: '#c12e34'
		                    }
		                }
		            },
		            emphasis: {
		                areaStyle: {
		                    color: '#99d2dd'
		                },
		                label: {
		                    textStyle: {
		                        color: '#c12e34'
		                    }
		                }
		            }
		        }
		    },
		    force: {
		        itemStyle: {
		            normal: {
		                linkStyle: {
		                    strokeColor: '#408829'
		                }
		            }
		        }
		    },
		    chord: {
		        padding: 4,
		        itemStyle: {
		            normal: {
		                lineStyle: {
		                    width: 1,
		                    color: 'rgba(128, 128, 128, 0.5)'
		                },
		                chordStyle: {
		                    lineStyle: {
		                        width: 1,
		                        color: 'rgba(128, 128, 128, 0.5)'
		                    }
		                }
		            },
		            emphasis: {
		                lineStyle: {
		                    width: 1,
		                    color: 'rgba(128, 128, 128, 0.5)'
		                },
		                chordStyle: {
		                    lineStyle: {
		                        width: 1,
		                        color: 'rgba(128, 128, 128, 0.5)'
		                    }
		                }
		            }
		        }
		    },
		    gauge: {
		        startAngle: 225,
		        endAngle: -45,
		        axisLine: {
		            show: true,
		            lineStyle: {
		                color: [
		                    [0.2, '#86b379'],
		                    [0.8, '#68a54a'],
		                    [1, '#408829']
		                ],
		                width: 8
		            }
		        },
		        axisTick: {
		            splitNumber: 10,
		            length: 12,
		            lineStyle: {
		                color: 'auto'
		            }
		        },
		        axisLabel: {
		            textStyle: {
		                color: 'auto'
		            }
		        },
		        splitLine: {
		            length: 18,
		            lineStyle: {
		                color: 'auto'
		            }
		        },
		        pointer: {
		            length: '90%',
		            color: 'auto'
		        },
		        title: {
		            textStyle: {
		                color: '#333'
		            }
		        },
		        detail: {
		            textStyle: {
		                color: 'auto'
		            }
		        }
		    },
		    textStyle: {
		        fontFamily: 'Arial, Verdana, sans-serif'
		    }
		};
		var echartPie = echarts.init(document.getElementById('echart_pie'), theme);
		
		echartPie.setOption({
		    tooltip: {
		        trigger: 'item',
		        formatter: "{a} <br/>{b} : {c} ({d}%)"
		    },
		    legend: {
		        x: 'center',
		        y: 'bottom',
		        data: ['Direct Access', 'E-mail Marketing', 'Union Ad', 'Video Ads', 'Search Engine']
		    },
		    toolbox: {
		        show: true,
		        feature: {
		            magicType: {
		                show: true,
		                type: ['pie', 'funnel'],
		                option: {
		                    funnel: {
		                        x: '25%',
		                        width: '50%',
		                        funnelAlign: 'left',
		                        max: 1548
		                    }
		                }
		            },
		            restore: {
		                show: true,
		                title: "Restore"
		            },
		            saveAsImage: {
		                show: true,
		                title: "Save Image"
		            }
		        }
		    },
		    calculable: true,
		    series: [{
		        name: 'Camps',
		        type: 'pie',
		        radius: '55%',
		        center: ['50%', '48%'],
		        data: [
			        <?php
				        foreach($speciality_arr as $key => $speciality_val){
					        ?>
					        {
						        value: <?=$speciality_val?>,
						        name: '<?=$key?>'
					        },
					        <?php
				        }
				    ?>
		            ]
		    }]
		});
		
		var dataStyle = {
		    normal: {
		        label: {
		            show: false
		        },
		        labelLine: {
		            show: false
		        }
		    }
		};
		
		var placeHolderStyle = {
		    normal: {
		        color: 'rgba(0,0,0,0)',
		        label: {
		            show: false
		        },
		        labelLine: {
		            show: false
		        }
		    },
		    emphasis: {
		        color: 'rgba(0,0,0,0)'
		    }
		};
    </script>
  </body>
</html>
