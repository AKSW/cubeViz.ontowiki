/**
 * Chart configuration
 * 
 * Each key represents the "maximum" number of multiple dimensions which can
 * be represents by one of the items in charts-array. That means, a bar chart
 * which has maximum number of two is also able to display only one dimension.
 */
var CubeViz_ChartConfig = {
    
    /**
     * No multiple dimensions
     */
    "0": [        
    ],
    
    /**
     * One multiple dimensions
     */
    "1": [
    ],
    
    /**
     * Two multiple dimensions
     */
    "2": [
        {
            "group": "bar2",
            "types": [ 
                {   
                    "label": "bar",
                    "enabled": true,
                    /**
                     * Configuration object
                     * Here you can directly configure your HighCharts
                     */
                    "config": {
                        "chart.type": "bar",
                        "plotOptions.series.color": "#ff0000" 
                    },
                    "class": "Bar2",
                    "icon": "bar.png"
                }
            ]
        }
    ]
};
