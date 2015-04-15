DECLARE @PATH_PHOTO VARCHAR(128)
SET @PATH_PHOTO ='/photos/'

INSERT INTO Zdjecie(sprzet, link)
  VALUES(
  (SELECT id FROM Sprzet WHERE nazwa='Elipsometr spektralny M-2000 (J.A. Woollam Co., Inc. Ellipsometry Solutions)'),
  (SELECT @PATH_PHOTO + 'elipsometr1.jpg')
  );
  
INSERT INTO Zdjecie(sprzet, link)
  VALUES(
  (SELECT id FROM Sprzet WHERE nazwa='Klaster komputerowy z serwerami'),
  (SELECT @PATH_PHOTO + 'klaster1.jpg')
  );
  
INSERT INTO Zdjecie(sprzet, link)
  VALUES(
  (SELECT id FROM Sprzet WHERE nazwa='Zintegrowany system do syntezy i diagnostyki nanostruktur w warunkach ultrawysokiej prózni i w ekstremalnych temperaturach (Omikron)'),
  (SELECT @PATH_PHOTO + 'labnano_1.jpg')
  );
  
INSERT INTO Zdjecie(sprzet, link)
  VALUES(
  (SELECT id FROM Sprzet WHERE nazwa='Zintegrowany system do syntezy i diagnostyki nanostruktur w warunkach ultrawysokiej prózni i w ekstremalnych temperaturach (Omikron)'),
  (SELECT @PATH_PHOTO + 'labnano_2.jpg')
  );
  
INSERT INTO Zdjecie(sprzet, link)
  VALUES(
  (SELECT id FROM Sprzet WHERE nazwa='Mikroskop konfokalny (mikroskop odwrócony Nikon Ti-E z systemem konfokalnym Nikon A1)'),
  (SELECT @PATH_PHOTO + 'mikroskop_konfokalny_1.jpg')
  );
  
INSERT INTO Zdjecie(sprzet, link)
  VALUES(
  (SELECT id FROM Sprzet WHERE nazwa='Mikroskop konfokalny (mikroskop odwrócony Nikon Ti-E z systemem konfokalnym Nikon A1)'),
  (SELECT @PATH_PHOTO + 'mikroskop_konfokalny_2.jpg')
  );
  
INSERT INTO Zdjecie(sprzet, link)
  VALUES(
  (SELECT id FROM Sprzet WHERE nazwa='Zestaw do spektroskopii mössbauerowskiej z wyposazeniem dodatkowym i oprogramowaniem'),
  (SELECT @PATH_PHOTO + 'mossbauer_a_2.jpg')
  );
  
INSERT INTO Zdjecie(sprzet, link)
  VALUES(
  (SELECT id FROM Sprzet WHERE nazwa='Zestaw do spektroskopii mössbauerowskiej z wyposazeniem dodatkowym i oprogramowaniem'),
  (SELECT @PATH_PHOTO + 'mossbauer_b_1.jpg')
  );
  
INSERT INTO Zdjecie(sprzet, link)
  VALUES(
  (SELECT id FROM Sprzet WHERE nazwa='Uklad do spektrometrii mössbauerowskiej w zakresie temperatur od 2.2K do 300K ze zródlem w temperaturze pokojowej'),
  (SELECT @PATH_PHOTO + 'mossbauer_s_03.jpg')
  );
  
INSERT INTO Zdjecie(sprzet, link)
  VALUES(
  (SELECT id FROM Sprzet WHERE nazwa='System lasera OPO: optyczny oscylator parametryczny z laserem pompujacym'),
  (SELECT @PATH_PHOTO + 'opo2.jpg')
  );
  
INSERT INTO Zdjecie(sprzet, link)
  VALUES(
  (SELECT id FROM Sprzet WHERE nazwa='System lasera OPO: optyczny oscylator parametryczny z laserem pompujacym'),
  (SELECT @PATH_PHOTO + 'opo3.jpg')
  );
  
INSERT INTO Zdjecie(sprzet, link)
  VALUES(
  (SELECT id FROM Sprzet WHERE nazwa='Spektrometr oraz kamera CCD ze wzmacniaczem obrazu (Princeton Instruments)'),
  (SELECT @PATH_PHOTO + 'spec_n_cam.jpg')
  );
  
  
/*
INSERT INTO Zdjecie(sprzet, link)
  VALUES(
  (SELECT id FROM Sprzet WHERE nazwa=''),
  (SELECT @PATH_PHOTO + '')
  );
*/
