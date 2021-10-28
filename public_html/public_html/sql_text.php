<?php

$sql1 = '
SELECT
date(st_rez.created) as work_date,
SUM(st_rez.bed) as work_bed,
SUM(st_rez.towels) as work_towels,
SUM(st_rez.r_cost) as work_rcost,
SUM(st_rez.zaezd) as zaezd,
SUM(st_rez.gen) as gen,
SUM(st_rez.tek) as tek,
st_rez.time_start as time_start,
st_rez.time_end as time_end

FROM

(
SELECT
statistics.id as stat_id,
statistics.created as created,
statistics.bed,
statistics.towels,
statistics.start,
statistics.end,
stprice.r_cost as r_cost,

t1.start as time_start,
t1.end as time_end,


w1.work as zaezd,
w2.work as gen,
w3.work as tek

/*,

bed.bed as bed,
tow.towels as towels

*/

from
statistics

LEFT JOIN 

(
    
SELECT
stroombuild.stat_id as stat_id,
prices.price as r_cost

FROM
prices

LEFT JOIN

(SELECT
builds.hotel as b_hotel,
stroom.stat_room as stat_room,
stroom.r_type as r_type,
stroom.stat_work as stat_work,
stroom.stat_id as stat_id

FROM
builds

LEFT JOIN

(SELECT
statistics.room as stat_room,
statistics.id as stat_id, 
statistics.work as stat_work,
ro.build as ro_build,
ro.r_type as r_type
FROM
statistics

LEFT JOIN
(SELECT
 rooms.id as r_id,
 rooms.type as r_type,
 rooms.build as build
 FROM
 rooms) ro
 on statistics.room = ro.r_id) stroom
 on builds.id = stroom.ro_build) stroombuild
 on prices.hotel = stroombuild.b_hotel AND prices.work = stroombuild.stat_work and prices.room_type = stroombuild.r_type
 
) stprice
on statistics.id = stprice.stat_id

LEFT JOIN 
(SELECT
date(statistics.created) as created,
time(start) as start,
time(end) as end
from
statistics
 where statistics.work = 0
 GROUP BY date(statistics.created)) t1 
 on date(statistics.created) = t1.created
 
 
 LEFT JOIN
(SELECT
statistics.id as st_id,
count(*) as work
from
statistics
 where statistics.work = 1
GROUP BY statistics.id) w1 
 on statistics.id = w1.st_id
 
LEFT JOIN 
(SELECT
statistics.id as st_id,
count(*) as work
from
statistics
 where statistics.work = 2
GROUP BY statistics.id) w2 
 on statistics.id = w2.st_id


LEFT JOIN 
(SELECT
statistics.id as st_id,
count(*) as work
from
statistics
 where statistics.work = 3
GROUP BY statistics.id) w3 
 on statistics.id = w3.st_id
    
) st_rez

GROUP BY date(statistics.created)

';


$sql2 = '
SELECT
statistics.id as stat_id,
time(statistics.start) as w_start,
time(statistics.end) as w_end,
statistics.work as work,
statistics.room as st_room,
statistics.bed as w_bed,
statistics.towels as w_towels,
cost.r_cost as r_cost,
cost.r_type as r_type,
cost.b_name as build_name

FROM
statistics

LEFT JOIN

(SELECT
stroombuild.stat_id as stat_id,
stroombuild.b_name as b_name,
prices.price as r_cost,
prices.room_type as r_type

FROM
prices

LEFT JOIN

(SELECT
builds.hotel as b_hotel,
builds.name as b_name,
stroom.stat_room as stat_room,
stroom.r_type as r_type,
stroom.stat_work as stat_work,
stroom.stat_id as stat_id

FROM
builds

LEFT JOIN

(SELECT
statistics.room as stat_room,
statistics.id as stat_id, 
statistics.work as stat_work,
ro.build as ro_build,
ro.r_type as r_type
FROM
statistics

LEFT JOIN
(SELECT
 rooms.id as r_id,
 rooms.type as r_type,
 rooms.build as build
 FROM
 rooms) ro
 on statistics.room = ro.r_id) stroom
 on builds.id = stroom.ro_build) stroombuild
 on prices.hotel = stroombuild.b_hotel AND prices.work = stroombuild.stat_work and prices.room_type = stroombuild.r_type) cost
 on statistics.id = cost.stat_id
 
 WHERE statistics.work <> 0 AND date(statistics.created) = 
';
