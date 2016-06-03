confWidgetConfig = {
    initSize: {width: 900, height: 200},
    url: "",
    path: 'ApiProxy.php?type=properties',
    type: 'property',
    timespan: '10 year',
    transpose: true,
    responsive: false,
    updateinterval: 0,
    expandtags: true,
    columns: [
        {
            key: 'entity',
            label: 'Host'
        },
        {
            key: 'time',
            hidden: true
        }
            
    ],
    properties: [
        {
        }
    ]
};
