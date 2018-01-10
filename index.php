<?php
/**
 * Created by PhpStorm.
 * User: severus
 * Date: 2018/1/10
 * Time: 下午9:53
 */

include 'vendor/autoload.php';
include 'Source/NormalDistribution.php';

/**
 * 使用示例：
 *   Ⅰ.传入列表后，在构造方法中已经完成计算，直接使用即可。
 */
$metaData = [51.7, 50.6, 57.9, 56.9, 56.7, 56.7, 55.3, 56.1, 53.7, 54.5, 56.9, 51.9, 52.1, 55.1, 54.9, 54.7, 55.3, 55.3, 54.5, 54.9, 54.5, 55.3, 54.9, 54.3, 53.7, 53.5, 53.7, 53.1, 54.5, 53.1, 53.9, 53.5, 53.3, 53.9, 53.5, 53.5, 52.5, 53.3, 53.5, 53.3, 53.7, 53.1, 54.5, 53.9, 56.7, 54.5, 54.3, 55.1, 54.1, 54.5, 53.9, 53.1, 53.3, 55.3, 55.7, 56.1, 54.7, 53.1, 53.3, 52.7, 53.1, 52.9, 53.1, 54.3, 53.1, 52.7, 53.1, 53.3, 53.1, 53.3, 53.1, 53.3, 55.1, 54.7, 54.9, 54.3, 53.9, 53.7, 53.9, 53.5, 54.5, 54.3, 55.5, 55.7, 55.5, 54.9, 55.3, 55.5, 53.7, 54.1, 53.9, 55.7, 55.9, 53.7, 53.5, 53.1, 52.3, 52.7, 52.9, 53.3, 53.9, 52.7, 53.5, 53.1, 52.7, 51.9, 52.5, 53.9, 54.5, 55.7, 55.3, 54.9, 53.1, 52.9, 54.1, 53.3, 54.7, 53.9, 54.3, 54.1, 53.7, 53.3, 52.7, 52.9, 52.5, 53.9, 53.5, 54.1, 54.1, 54.7, 54.9, 54.9, 54.1, 53.3, 52.9, 53.7, 53.9, 54.3, 54.1, 54.5, 54.7, 54.9, 52.1, 52.9, 53.5, 52.7, 53.1, 53.1, 53.5, 52.9, 52.9, 53.1, 53.3, 52.7, 53.5, 53.9, 54.9, 55.1, 54.3, 55.1, 54.3, 54.3, 53.9, 54.5, 54.5, 54.3, 55.3, 54.5, 54.9, 53.5, 52.1, 55.3, 55.7, 55.7, 55.5, 54.5, 57.7, 54.7, 53.7, 53.1, 53.7, 55.9, 56.1, 53.9, 53.7, 53.3, 53.9, 53.9, 54.5, 54.7, 56.1, 55.7, 53.1, 53.7, 53.5, 53.9, 53.9, 53.5, 53.3, 53.1, 52.5, 55.9, 55.7, 54.1, 54.3, 54.1, 54.1, 54.5, 54.5, 55.1, 53.1, 53.3, 54.1, 54.3, 53.9, 54.1, 54.7, 54.7, 53.7, 53.1, 53.3, 52.7, 53.5, 52.9, 53.7, 56.5, 56.1, 55.7, 55.5, 56.9, 57.7, 56.5, 55.7, 54.1, 54.7, 55.7, 55.5, 53.1, 52.7, 53.1, 53.3, 53.5, 54.3, 54.1, 54.5, 54.7, 55.7, 55.5, 54.1, 54.3, 54.7, 53.1, 53.3, 53.1, 52.7, 53.1, 53.7, 53.1, 54.7, 54.5, 55.1, 54.7, 54.5, 56.1, 55.7, 53.3, 52.5, 53.7, 54.1, 53.3, 52.1, 52.3, 53.1, 53.3, 53.5, 53.3, 53.1, 52.7, 53.1, 55.7, 55.1, 54.3, 53.7, 53.1, 52.9, 53.1, 52.7, 52.5, 53.1, 53.5, 53.1, 53.3, 54.1, 55.1, 54.9, 56.1, 55.7, 56.5, 54.7, 53.7];
$normalDistributionObj = new NormalDistribution($metaData);
?>

<script src="./node_modules/echarts/dist/echarts.min.js"></script>
<script src="./node_modules/jquery/dist/jquery.min.js"></script>

<script>
    /**
     * Ⅱ.处理好要使用的数据
     */
    var normalDistributionPointArray = JSON.parse('<?php echo json_encode($normalDistributionObj->normalDistributionPointArray) ?>');
    var frequencyArray = JSON.parse('<?php echo json_encode($normalDistributionObj->frequencyArray) ?>');

    var xAxisData = [];
    var seriesData = [];
    $.each(frequencyArray, function (key, value) {
        xAxisData.push(parseFloat(key).toFixed(2))
        seriesData.push(value)
    });
</script>

<h2>github: Mitiin/php-NormalDistributionGraph / 正态分布图</h2>
<hr/>
<!-- 为ECharts准备一个具备大小（宽高）的Dom -->
<div id="main" style="width: 600px;height:400px;"></div>

<script>
    /**
     * Ⅲ.渲染图标
     */

    // 基于准备好的dom，初始化echarts实例
    var myChart = echarts.init(document.getElementById('main'));

    var colors = ['#5793f3', '#d14a61', '#675bba'];

    option = {
        color: colors,

        tooltip: {
            trigger: 'none',
            axisPointer: {
                type: 'cross'
            }
        },
        legend: {
            data: ['正态分布图', '频率图']
        },
        grid: {
            top: 70,
            bottom: 50
        },
        xAxis: [
            {
                type: 'category',
                axisTick: {
                    alignWithLabel: true
                },
                axisLine: {
                    onZero: false,
                    lineStyle: {
                        color: colors[1]
                    }
                },
                axisPointer: {
                    label: {
                        formatter: function (params) {
                            return '区间数量  ' + params.value
                                + (params.seriesData.length ? '：' + params.seriesData[0].data : '');
                        }
                    }
                },
                data: xAxisData
            }
        ],
        yAxis: [
            {
                type: 'value',
                show: false

            },
            {
                type: 'value',
                position: 'left'
            }
        ],
        series: [
            {
                name: '正态分布图',
                type: 'line',
                symbol: 'none',  //这句就是去掉点的
                smooth: true,
                data: normalDistributionPointArray
            },
            {
                name: '频率图',
                type: 'bar',
                barWidth: '60%',
                yAxisIndex: 1,
                data: seriesData
            }

        ]
    };

    // 使用刚指定的配置项和数据显示图表。
    myChart.setOption(option);

</script>

