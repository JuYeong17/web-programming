CREATE TABLE communication_comments (
   comment_num INT NOT NULL AUTO_INCREMENT,
   parent_num INT NOT NULL,
   id CHAR(15) NOT NULL,
   name CHAR(10) NOT NULL,
   comment_content TEXT NOT NULL,
   comment_regist_day CHAR(20) NOT NULL,
   PRIMARY KEY (comment_num),
   INDEX (parent_num)
);
