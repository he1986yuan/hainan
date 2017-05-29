#优化MYSQL数据库的方法
1、选取最适用的字段属性,尽可能减少定义字段长度,尽量把字段设置NOT NULL,例如’省份,性别’,最好设置为ENUM
2、使用连接（JOIN）来代替子查询:
3、使用联合(UNION)来代替手动创建的临时表
4、事务处理:
5、锁定表,优化事务处理:
6、使用外键,优化锁定表
7、建立索引:
	a.格式:
	(普通索引)->
	创建:CREATE INDEX <索引名> ON tablename (索引字段)
	修改:ALTER TABLE tablename ADD INDEX [索引名] (索引字段)
	创表指定索引:CREATE TABLE tablename([...],INDEX[索引名](索引字段))
	(唯一索引)->
	创建:CREATE UNIQUE <索引名> ON tablename (索引字段)
	修改:ALTER TABLE tablename ADD UNIQUE [索引名] (索引字段)
	创表指定索引:CREATE TABLE tablename([...],UNIQUE[索引名](索引字段))
	(主键)->
	它是唯一索引,一般在创建表是建立,格式为:
CREATE TABLE tablename ([...],PRIMARY KEY[索引字段])
8、优化查询语句
9、建立读写分离的主从式数据库

10、分表水平分表垂直分表

###mysISAM与InnoDB数据库的索引结构的区别
