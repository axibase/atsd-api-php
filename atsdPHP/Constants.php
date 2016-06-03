<?php
/*
* Copyright 2015 Axibase Corporation or its affiliates. All Rights Reserved.
*
* Licensed under the Apache License, Version 2.0 (the "License").
* You may not use this file except in compliance with the License.
* A copy of the License is located at
*
* https://www.axibase.com/atsd/axibase-apache-2.0.pdf
*
* or in the "license" file accompanying this file. This file is distributed
* on an "AS IS" BASIS, WITHOUT WARRANTIES OR CONDITIONS OF ANY KIND, either
* express or implied. See the License for the specific language governing
* permissions and limitations under the License.
*/

namespace axibase\atsdPHP;

abstract class TimeUnit {
    const MILLISECOND = 'MILLISECOND';
    const YEAR = 'YEAR';
    const QUARTER = 'QUARTER';
    const MONTH = 'MONTH';
    const WEEK = 'WEEK';
    const DAY = 'DAY';
    const HOUR = 'HOUR';
    const MINUTE = 'MINUTE';
    const SECOND = 'SECOND';
}

abstract class AggregateType {
    const DETAIL = 'DETAIL';
    const AVG = 'AVG';
    const MAX = 'MAX';
    const MIN = 'MIN';
    const COUNT = 'COUNT';
    const SUM = 'SUM';
    const PERCENTILE_999 = 'PERCENTILE_999';
    const PERCENTILE_995 = 'PERCENTILE_995';
    const PERCENTILE_99 = 'PERCENTILE_99';
    const PERCENTILE_95 = 'PERCENTILE_95';
    const PERCENTILE_90 = 'PERCENTILE_90';
    const PERCENTILE_75 = 'PERCENTILE_75';
    const PERCENTILE_50 = 'PERCENTILE_50';
    const STANDARD_DEVIATION = 'STANDARD_DEVIATION';
    const FIRST = 'FIRST';
    const LAST = 'LAST';
    const DELTA = 'DELTA';
    const WAVG = 'WAVG';
    const WTAVG = 'WTAVG';
    const THRESHOLD_COUNT = "THRESHOLD_COUNT";
    const THRESHOLD_DURATION = "THRESHOLD_DURATION";
    const THRESHOLD_PERCENT = "THRESHOLD_PERCENT";
}

abstract class SeriesTypes {
    const HISTORY = 'HISTORY';
    const FORECAST = 'FORECAST';
    const FORECAST_DEVIATION = 'FORECAST_DEVIATION';
}
