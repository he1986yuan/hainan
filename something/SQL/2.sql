#如果在数据库中包含GROUP BY HAVING ORDER BY谭门的顺序就是1GROUPBY 2HAVING 3ORDER BY
#统计各个部门的平均工资并且是大于1000 并且按照工资从高到低排序
select avg(sal) as myavg,deptno from emp group by deptno having myavg>100 order by myavg desc;

#链接查询
外链接
select * from stuts left join exam on stus.id =exam.id;
现实所有人的信息包括成绩，如果没有成绩也要现实左表中的id name等信息成绩现实为空
#内联接
就是where a.status =b.status 情况
