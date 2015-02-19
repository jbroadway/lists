create table #prefix#lists (
	id int not null auto_increment primary key, 
	name char(48) not null, 
	description text,
	index (name)
);

create table #prefix#lists_member (
	id int not null auto_increment primary key,
	list int not null,
	user int not null,
	notes text,
	unique (list, user),
	index (list),
	index (user)
);
