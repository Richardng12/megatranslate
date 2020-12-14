CREATE DATABASE translationMapping;

use translationMapping;

CREATE TABLE translations ( 
    id INT(11) UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    english TEXT,
    spanish TEXT,
    chinese TEXT,
    japanese TEXT,
    french TEXT,
    korean TEXT,
    russian TEXT,
    hindi TEXT,
    italian TEXT
  );


ALTER TABLE translations ADD FULLTEXT (english);

INSERT INTO translations (english, spanish, chinese, japanese, french, korean, russian, hindi, italian )
VALUES ("hello", "ola","你好","こんにちは","bonjour", "여보세요","Здравствуйте","नमस्ते","Ciao"); 

INSERT INTO translations (english, spanish, chinese, japanese, french, korean, russian, hindi, italian )
VALUES ("thank you", "gracias","谢谢","ありがとうございました","Je vous remercie", "감사합니다","благодарю вас","धन्यवाद","grazie"); 

INSERT INTO translations (english, spanish, chinese, japanese, french, korean, russian, hindi, italian )
VALUES ("hello my name is Richard", "Hola, mi nombre es Richard","你好我的名字是 Richard","こんにちは、私の名前は Richard","Bonjour, je m'appelle Richard", "안녕 내 이름은 Richard","Привет меня зовут Richard","नमस्ते मेरा नाम है Richard","Ciao il mio nome è Richard"); 