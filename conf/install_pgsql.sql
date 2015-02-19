create sequence #prefix#lists_id_seq;

create table #prefix#lists (
	id integer not null default nextval('#prefix#lists_id_seq') primary key, 
	name char(48) not null, 
	description text
);

create index #prefix#lists_name on #prefix#lists (name);

create sequence #prefix#lists_member_id_seq;

create table #prefix#lists_member (
	id integer default nextval('#prefix#lists_member_id_seq') primary key,
	list int not null,
	user int not null,
	notes text
);

create index #prefix#lists_member_list on #prefix#lists_member (list);
create index #prefix#lists_member_user on #prefix#lists_member (user);
create unique index #prefix#lists_member_unique on #prefix#lists_member (list, user);
