CREATE TABLE sprint
(
  sprint_id INT(11) PRIMARY KEY NOT NULL AUTO_INCREMENT,
  name VARCHAR(64) NOT NULL,
  nb_days INT(11),
  created_at DATETIME NOT NULL,
  updated_at DATETIME
);

CREATE TABLE sprint_member
(
  sprint_member_id INT(11) PRIMARY KEY NOT NULL AUTO_INCREMENT,
  sprint_id INT(11) NOT NULL,
  nb_days_presence INT(11),
  availability INT(11),
  CONSTRAINT sprint_member_sprint_sprint_id_fk FOREIGN KEY (sprint_id) REFERENCES sprint (sprint_id)
);

CREATE INDEX sprint_member_sprint_sprint_id_fk ON sprint_member (sprint_id);
