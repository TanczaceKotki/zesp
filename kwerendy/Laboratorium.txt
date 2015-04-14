INSERT INTO Laboratorium(nazwa, zespol)
  VALUES(
  'Laboratorium Mikroskopii Konfokalnej i Elipsometrii',
  (SELECT id FROM Zespol WHERE nazwa='Zespół Laboratoriów Nanotechnologii i Nauki o Powierzchni (NanoPow)')
  );
  
INSERT INTO Laboratorium(nazwa, zespol)
  VALUES(
  'Laboratorium Modelowania Molekularnego',
  (SELECT id FROM Zespol WHERE nazwa=' Centrum Zaawansowanych Technologii Obliczeniowych')
  );

INSERT INTO Laboratorium(nazwa, zespol)
  VALUES(
  'Laboratorium Nanostruktur',
  (SELECT id FROM Zespol WHERE nazwa='Zespół Laboratoriów Nanotechnologii i Nauki o Powierzchni (NanoPow)')
  );
  
INSERT INTO Laboratorium(nazwa, zespol)
  VALUES(
  'Laboratorium Spektroskopii Mössbauerowskiej',
 SELECT id FROM Zespol WHERE nazwa='Zespół Laboratoriów Zaawansowanych Materiałów (ZawMater)')
  );
  
INSERT INTO Laboratorium(nazwa, zespol)
  VALUES(
  'Laboratorium Diagnostyki Fotonicznej',
  (SELECT id FROM Zespol WHERE nazwa='Zespół Laboratoriów Fotoniki, Spektroskopii i Laserowych Technologii Kwantowych (FotoSpekLas)')
  );

/*
INSERT INTO Laboratorium(nazwa, zespol)
  VALUES(
  '',
  (SELECT id FROM Zespol WHERE nazwa='')
  );
*/
