create table work.jobs
(
	id int auto_increment,
	name varchar(255) null,
	status tinyint default 1 null,
	start_time datetime not null,
	end_time datetime not null,
	created_at datetime null,
	updated_at datetime null,
	deleted_at datetime null,
	constraint jobs_pk primary key (id)
);