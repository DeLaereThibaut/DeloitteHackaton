-- create tables

create table Comments
(
    comment_id INT auto_increment primary key,
    comments   varchar(255),
    date       timestamp,
    user_id    INT
);
create table Contacts
(
    contact_id     INT auto_increment primary key,
    email          varchar(50),
    firstname      varchar(50),
    lastname       varchar(50),
    phone          varchar(50),
    position       varchar(50),
    primaryContact boolean,
    school_id      INT
);
create table SchoolEvents
(
    event_id          INT auto_increment primary key,
    school_id         INT,
    country_id        INT,
    endDate           timestamp,
    eventPrice        double,
    fiscalYear        int,
    internal          boolean,
    internalStructure varchar(50),
    location          varchar(50),
    name              varchar(50),
    startDate         timestamp,
    targetedProfiles  varchar(50),
    type_id              varchar(50)
);
create table SchoolEventsHasComments
(
    comment_id INT,
    event_id   INT
);
create table SchoolHasComments
(
    comment_id INT,
    school_id  INT
);
create table StudentsHasComments
(
    comment_id INT,
    student_id INT
);
create table ContactsHasComments
(
    comment_id INT,
    contact_id INT
);
create table EventHasUser
(
    event_id INT,
    user_id  INT
);
create table EventHostedStudent
(
    event_id   INT,
    student_id INT
);
create table SchoolHasUser
(
    school_id INT,
    user_id   INT
);
create table Schools
(
    school_id         INT auto_increment primary key,
    address           varchar(255),
    internalStructure varchar(50),
    name              varchar(50),
    sponsored         int,
    targeted          boolean,
    website           varchar(255)
);
create table Students
(
    student_id       INT auto_increment primary key,
    contractType     INT,
    ambassador_id    INT,
    feedback         varchar(255),
    email            varchar(50),
    firstname        varchar(50),
    gender           INT,
    lastname         varchar(50),
    phoneNumber      varchar(50),
    `status`           INT,
    workPermit       boolean,
    `hash`      VARCHAR(255)
);
create table Users
(
    user_id        INT auto_increment primary key,
    ambassadorType varchar(50),
    remember_token varchar(255),
    password       varchar(255),
    username       varchar(50),
    email          varchar(50)
);
create table TargetedProfiles
(
    id   INT auto_increment primary key,
    name varchar(70)
);
create table InternalStructure
(
    id   INT auto_increment primary key,
    name varchar(70)
);
create table EventType
(
    id   INT auto_increment primary key,
    name varchar(70)
);
create table Country
(
    id   INT auto_increment primary key,
    name varchar(70)
);
create table StudentStatus
(
    id   INT auto_increment primary key,
    name varchar(70)
);
create table Gender
(
    id   INT auto_increment primary key,
    name varchar(70)
);
create table ContractType
(
    id   INT auto_increment primary key,
    name varchar(70)
);
create table SchoolEventsHaveTargetedProfiles
(
    event_id            INT,
    targetedProfiles_id INT
);
create table SchoolsHaveTargetedProfiles
(
    school_id           INT,
    targetedProfiles_id INT
);
create table StudentsHaveTargetedProfiles
(
    student_id          INT,
    targetedProfiles_id INT
);
-- add foreign keys
alter table SchoolEventsHaveTargetedProfiles
    add constraint fk_100 foreign key (event_id) references SchoolEvents (event_id)
;
alter table SchoolEventsHaveTargetedProfiles
    add constraint fk_101 foreign key (targetedProfiles_id) references TargetedProfiles (id)
;
alter table SchoolsHaveTargetedProfiles
    add constraint fk_102 foreign key (school_id) references Schools (school_id)
;
alter table SchoolsHaveTargetedProfiles
    add constraint fk_103 foreign key (targetedProfiles_id) references TargetedProfiles (id)
;
alter table StudentsHaveTargetedProfiles
    add constraint fk_104 foreign key (student_id) references Students (student_id)
;
alter table SchoolsHaveTargetedProfiles
    add constraint fk_105 foreign key (targetedProfiles_id) references TargetedProfiles (id)
;
alter table Comments
    add constraint fk_63 foreign key (user_id) references Users (user_id)
;
alter table Contacts
    add constraint fk_58 foreign key (school_id) references Schools (school_id)
;
alter table EventHasUser
    add constraint fk_65 foreign key (event_id) references SchoolEvents (event_id)
;
alter table EventHasUser
    add constraint fk_66 foreign key (user_id) references Users (user_id)
;
alter table SchoolHasComments
    add constraint fk_90 foreign key (school_id) references Schools (school_id)
;
alter table SchoolHasComments
    add constraint fk_91 foreign key (comment_id) references Comments (comment_id)
;
alter table StudentsHasComments
    add constraint fk_92 foreign key (student_id) references Students (student_id)
;
alter table StudentsHasComments
    add constraint fk_93 foreign key (comment_id) references Comments (comment_id)
;
alter table ContactsHasComments
    add constraint fk_94 foreign key (contact_id) references Contacts (contact_id)
;
alter table ContactsHasComments
    add constraint fk_95 foreign key (comment_id) references Comments (comment_id)
;
alter table SchoolEventsHasComments
    add constraint fk_96 foreign key (event_id) references SchoolEvents (event_id)
;
alter table SchoolEventsHasComments
    add constraint fk_97 foreign key (comment_id) references Comments (comment_id)
;
alter table SchoolHasUser
    add constraint fk_98 foreign key (school_id) references Schools (school_id)
;
alter table SchoolHasUser
    add constraint fk_99 foreign key (user_id) references Users (user_id)
;
alter table EventHostedStudent
    add constraint fk_53 foreign key (event_id) references SchoolEvents (event_id)
;
alter table EventHostedStudent
    add constraint fk_54 foreign key (student_id) references Students (student_id)
;
alter table SchoolEvents
    add constraint fk_52 foreign key (school_id) references Schools (school_id)
;


-- add table indices

create unique index RI1 on EventHostedStudent (event_id, student_id);
create unique index RI2 on EventHasUser (event_id, user_id);
create unique index RI3 on StudentsHasComments (student_id, comment_id);
create unique index RI4 on SchoolEventsHasComments (event_id, comment_id);
create unique index RI5 on SchoolHasComments (school_id, comment_id);
create unique index RI6 on ContactsHasComments (contact_id, comment_id);
create unique index RI7 on SchoolHasUser (school_id, user_id);
create unique index RI8 on SchoolEventsHaveTargetedProfiles (event_id, targetedProfiles_id);
create unique index RI9 on SchoolsHaveTargetedProfiles (school_id, targetedProfiles_id);
create unique index RI10 on StudentsHaveTargetedProfiles (student_id, targetedProfiles_id);

-- fill with data

insert into ContractType (name) value ('Internship');
insert into ContractType (name) value ('CDI');
insert into Gender (name) value ('Male');
insert into Gender (name) value ('Female');
insert into StudentStatus (name) value ('TBR');
insert into StudentStatus (name) value ('To discuss');
insert into StudentStatus (name) value ('Immediately');
insert into Country (name) value ('Belgium');
insert into Country (name) value ('England');
insert into Country (name) value ('France');
insert into Country (name) value ('Germany');
insert into Country (name) value ('Ireland');
insert into Country (name) value ('Italy');
insert into Country (name) value ('Luxembourg');
insert into Country (name) value ('Hungary');
insert into Country (name) value ('Poland');
insert into Country (name) value ('Spain');
insert into Country (name) value ('International');
insert into EventType (name)
values ('Branding Event');
insert into EventType (name)
values ('Challenge');
insert into EventType (name)
values ('Interview');
insert into EventType (name)
values ('Job Fair');
insert into EventType (name)
values ('Job Fair/Presentation');
insert into EventType (name)
values ('Job Fair/Workshop');
insert into EventType (name)
values ('Jury');
insert into EventType (name)
values ('Networking Event');
insert into EventType (name)
values ('Open Day');
insert into EventType (name)
values ('Other');
insert into EventType (name)
values ('Presentation');
insert into EventType (name)
values ('Presentation/Workshop');
insert into EventType (name)
values ('Seminaire Workshop');
insert into InternalStructure (name) value ('Audit');
insert into InternalStructure (name) value ('ACG');
insert into InternalStructure (name) value ('Tax');
insert into InternalStructure (name) value ('BSS/NO');
INSERT INTO TargetedProfiles (name)
VALUES ('Audit'),
       ('Audit IT'),
       ('Regulatory Strategy'),
       ('Corporate Finance'),
       ('Operations Consulting'),
       ('Digital'),
       ('Technology Consulting'),
       ('IT Risk'),
       ('Internal Audit'),
       ('Actuariat'),
       ('IT Audit'),
       ('Financial/ Business Risk'),
       ('AML/KYC'),
       ('Capital Market'),
       ('Financial services'),
       ('Tax'),
       ('Accounting'),
       ('Legal'),
       ('Administrive Assistant'),
       ('Developer'),
       ('HR'),
       ('Marketing/ Event'),
       ('Internal Finance'),
       ('Analytics and Data Management'),
       ('Cyber Security'),
       ('Systems');







