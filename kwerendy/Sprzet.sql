INSERT INTO Sprzet(nazwa, data_zakupu, data_uruchom, wartosc, opis, projekt, laboratorium)
  VALUES(
  'Elipsometr spektralny M-2000 (J.A. Woollam Co., Inc. Ellipsometry Solutions)',
  '2010-05',
  '2010-05',
   29091764,
  'Zakupiony elipsometr jest urzadzeniem o zmiennym kacie padania wiazki promieniowania na próbke, umozliwiajacym precyzyjne okreslenie grubosci 
warstwy powierzchniowej oraz jej wlasciwosci optycznych. Istnieje mozliwosc pomiaru w zakresie promieniowania od 246 do 998.5 nm. 
Elipsometr wyposazony jest w celke cieczowa LiquidCell o nominalnym kacie padania wiazki promieniowania 70º, dzieki czemu mozliwe 
jest badanie zmian wlasciwosci powierzchni w kontakcie z ciecza. Urzadzenie posiada ponadto zdolnosc pracy w trybie transmisyjnym. 
Dolaczone oprogramowanie ComleteEASE oraz WVASE32 pozwala na zbieranie danych pomiarowych oraz dopasowywanie modelu teoretycznego 
do uzyskanych wyników.',
  (SELECT id FROM Projekt WHERE nazwa="ATOMIN"),
  (SELECT id FROM Laboratorium WHERE nazwa='Laboratorium Mikroskopii Konfokalnej i Elipsometrii')
  );
  
INSERT INTO Sprzet(nazwa, data_zakupu, data_uruchom, wartosc, opis, projekt, laboratorium)
  VALUES(
  'Klaster komputerowy z serwerami',
  '2010-06',
  '2010-06',
  30736778,
  'W sklad klastra wchodzi serwer zarzadzajacy (pelniacy równoczesnie role serwera plików i maszyny dostepowej) oraz 76 wezlów obliczeniowych. 
Wezly obliczeniowe wyposazone sa w 1 procesor czterordzeniowy Intel Xeon X3460 lub 2 procesory czterordzeniowe Intel Xeon E5520. 
Pamiec RAM dostepna na wezlach wynosi od 8 do 32 GB. Sumarycznie dostepne sa 324 rdzenie i 750 GB RAM. Wezly wyposazone sa w lokalne 
dyski o pojemnosci 500 GB, poprzez system NFS udostepniane jest z serwera 3.7 TB przestrzeni dyskowej.
Na serwerze zainstalowane sa kompilatory gcc, gfortran oraz kompilatory PGI: C, C++, F95.
W klastrze dostepne jest m. in. oprogramowanie do obliczen kwantowochemicznych (Gaussian 09, QChem, NWChem, Gamess, ORCA, Dalton, CPMD), 
dynamiki molekularnej (NAMD, Gromacs, Amber, Tinker, CPMD) oraz do wizualizacji wyników (Molden, Gabedit, VMD). 
Obliczenia na klastrze uruchamiane sa pod kontrola systemu kolejkowego Sun Grid Engine.',
  (SELECT id FROM Projekt WHERE nazwa="ATOMIN"),
  (SELECT id FROM Laboratorium WHERE nazwa='Laboratorium Modelowania Molekularnego')
  );
  
INSERT INTO Sprzet(nazwa, data_zakupu, data_uruchom, wartosc, opis, projekt, laboratorium)
  VALUES(
  'Zintegrowany system do syntezy i diagnostyki nanostruktur w warunkach ultrawysokiej prózni i w ekstremalnych temperaturach (Omikron)',
  '2010-12',
  '2010-12',
  792457968,
  'Aparatura o nazwie Zintegrowany system do syntezy i diagnostyki nanostruktur" zainstalowana w Laboratorium Nanostruktur pozwala na prace w warunkach 
ultrawysokiej prózni (cisnienie bazowe lepsze niz 3x10-10 mbar we wszystkich komorach) z wykorzystaniem wielu nowoczesnych technik badawczych. 
Sklada sie z trzech zasadniczych czesci: komory przygotowawczej, komory mikroskopu SPM i komory mikroskopu czteropróbnikowego. 
Transfer próbek pomiedzy komorami odbywa sie w warunkach ultrawysokiej prózni z wykorzystaniem systemu magnetycznych transferów 
liniowych oraz manipulatorów szczypcowych. Próbki sa montowane na standardowych nosnikach firmy Omicron. 
Komora przygotowawcza pozwala na wygrzewanie próbek na manipulatorze XYZ w warunkach prózniowych do ok. 1000 K za pomoca grzejnika rezystywnego, 
badz do 1200K w wypadku próbek zamontowanych na specjalnych nosnikach umozliwiajacych ogrzanie bezposrednim przeplywem pradu. 
Manipulator pozwala równiez na chlodzenie próbki parami azotu do temperatury ok. 100 K. Powierzchnie moga byc przygotowywane przez rozpylanie jonami 
argonu pochodzacymi z dziala zmontowanego w komorze. Jakosc powierzchni moze byc szybko kontrolowana dzieki dyfraktometrowi powolnych elektronów (LEED). 
Komora wyposazona jest w szereg portów pozwalajacych na zamontowanie elementów koniecznych do wykonania danego eksperymentu np. komórek efuzyjnych, 
wag kwarcowych itp. W komorze mikroskopu bliskich oddzialywan SPM zamontowany jest kriogeniczny mikroskop SPM wyprodukowany przez firme Omicron. 
Pozwala on na badanie powierzchni z atomowa zdolnoscia rozdzielcza w zakresie temperatur rozciagajacym sie od temperatury cieklego helu (4K) 
do temperatury pokojowej. Mikroskop moze pracowac jako skaningowy mikroskop tunelowy STM przy wykorzystaniu standardowych ostrzy, jak równiez 
jako skaningowy mikroskop sil atomowych pracujacy w trybie bezkontaktowym (nc-AFM) dzieki wykorzystaniu rezonatorów piezoelektrycznych (ang. tuning fork) 
jako sensorów sily. Zmiana miedzy trybami pracy nie wymaga zapowietrzania ukladu prózniowego.
Komora mikroskopu czteropróbnikowego, oprócz samego mikroskopu czteropróbnikowego, zawiera kolumne skaningowego mikroskopu elektronowego SEM 
oraz hemisferyczny analizator energii elektronów. Mikroskop czteropróbnikowy jest urzadzeniem pozwalajacym na badanie elektrycznych wlasnosci 
nanostruktur. Jego zasada dzialania jest podobna do zasady dzialania mikroskopu STM, z tym ze do dyspozycji sa cztery ostrza, z których kazde 
moze dzialac jako ostrze STM (niejednoczesnie). Ostrza te mozna podlaczyc do nanostruktur odleglych od siebie nawet o 100 nm i zbadac ich przewodnictwo w nanoskali. 
Nawigacja ostrzami prowadzona jest dzieki podgladowi z mikroskopu SEM. Mikroskop SEM jest to kolumna Gemini, wyprodukowana przez firme Zeiss, 
pozwalajaca na wysokorozdzielcza prace w szerokim zakresie energii elektronów (rozdzielczosc lepsza niz 10 nm dla energii 1-30 keV). 
Hemisferyczny analizator energii elektronów NanoSam, wyprodukowany przez firme Omicron, w polaczeniu z wysokorozdzielcza wiazka elektronów z kolumny Gemini 
pozwala na analize skladu chemicznego powierzchni technika spektroskopii elektronów Augera z przestrzenna rozdzielczoscia lepsza niz 10 nm. Dodatkowo, 
temperatura próbki na stanowisku pomiarowym moze byc kontrolowana w zakresie 50K-500K.    ',
    (SELECT id FROM Projekt WHERE nazwa="ATOMIN"),
  (SELECT id FROM Laboratorium WHERE nazwa='Laboratorium Nanostruktur')
  );
  
INSERT INTO Sprzet(nazwa, data_zakupu, data_uruchom, wartosc, opis, projekt, laboratorium)
  VALUES(
  'Zestaw do spektroskopii mössbauerowskiej z wyposazeniem dodatkowym i oprogramowaniem',
  '2011-04',
  '2011-04',
  71390500, 
  'W sklad zakupionego zestawu wchodza: kriostat helowy firmy Janis z 9 T magnesem nadprzewodzacym, zasilacz magnesu, 
uklad pompowy do wysokiej i niskiej prózni, kontroler temperatury (LakeShore), spektrometr mössbauerowski (SEE CO) 
przystosowany do pracy w geometrii pionowej umozliwiajacy prace z równoczesnie chlodzonym zródlem i absorbentem 
oraz sterujacy instrumentem zestaw komputerowy wraz z niezbednym oprogramowaniem. 
Powyzszy zestaw pozwala na prowadzenie badan z zakresu spektroskopii rezonansowej gamma wszelkich materialów 
o charakterze cialo-stalowym zawierajacych w swoim skladzie izotopy mössbauerowskie w szerokim zakresie temperatur 1.3 K  300 K 
przy zastosowaniu silnych pól magnetycznych do 9 T. W szczególnosci uklad ten umozliwia badania materialów magnetycznych i biologicznych 
gdzie zastosowanie silnych pól magnetycznych pozwala na uzyskanie szczególowych informacji dotyczacych struktury elektronowej badanych substancji.',
    (SELECT id FROM Projekt WHERE nazwa="ATOMIN"),
  (SELECT id FROM Laboratorium WHERE nazwa='Laboratorium Spektroskopii Mössbauerowskiej')
  );
  
INSERT INTO Sprzet(nazwa, data_zakupu, data_uruchom, wartosc, opis, projekt, laboratorium)
  VALUES(
  'Uklad do spektrometrii mössbauerowskiej w zakresie temperatur od 2.2K do 300K ze zródlem w temperaturze pokojowej',
  '2011-03',
  '2011-03',
  35127345, 
  'W sklad ukladu wchodza dwa spektrometry mössbauerowskie oraz kriostat helowy. Kazdy ze spektrometrów sklada sie z przetwornika predkosci 
pozwalajacego na poruszanie zródlem promieniotwórczym z predkoscia do 300 mm/s, ksenonowego licznika proporcjonalnego oraz zintegrowanego 
przedwzmacniacza ladunkowy wraz ze wzmacniaczem. Uklad napedu przetwornika predkosci, generator funkcyjny oraz zasilacz wysokiego napiecia 
zasilane sa poprzez kasete systemu NIM.  Uklad akwizycji danych CMCA-550 przystosowany do wspólpracy z komputerem osobistym, 
pozwala nie tylko na prace w systemie spektrometru, ale takze dzieki systemowi analizy wysokosci impulsów, pozwala na wybór okna energetycznego. 
Uklad przystosowany jest do pomiarów mössbauerowskich z wykorzystaniem zródla promieniotwórczego 57Co. Kriostat helowy typu zanurzeniowego 
jest dedykowany do spektrometrii mössbauerowskiej z chlodzonym absorbentem. Zapewnia on stabilna temperature w zakresie od 2.3 K do 300 K, 
niskie zuzycie cieczy kriogenicznych oraz doskonala geometrie pomiaru. Wyniki pomiarów moga byc opracowywane przy pomocy zalaczonego 
zaawansowanego oprogramowania do obróbki numerycznej widm mössbauerowskich.',
    (SELECT id FROM Projekt WHERE nazwa="ATOMIN"),
  (SELECT id FROM Laboratorium WHERE nazwa='Laboratorium Spektroskopii Mössbauerowskiej')
  );
  
INSERT INTO Sprzet(nazwa, data_zakupu, data_uruchom, wartosc, opis, projekt, laboratorium)
  VALUES(
  'Laser wlóknowy 1560 nm z ukladem generacji drugiej harmonicznej (KEOPSYS)',
  '2012-03',
  '2012-03',
  27480700, 
  'Zestaw sklada sie z lasera swiatlowodowego typu KPS-KILAS-COOL-1560-15-PM-CO oraz ukladu do generacji drugiej harmonicznej.
Parametry lasera swiatlowodowego:

    dlugosc fali:   1560 nm
    moc wyjsciowa:    15 W
    strojenie czestotliwosci laserowej:    zgrubne 20 GHz i precyzyjne 200 MHz
    szerokosc linii laserowej (20 ms):     <10 kHz
    stabilnosc czestotliwosci (1 godz.):    20 MHz
    czestotliwosc szybkiej modulacji:     10 kHz
    polaryzacja swiatla wychodzacego:      PER > 20 dB
    wyjscie:    wlókno jednomodowe, kolimator optyczny
    ksztalt wiazki:     TEM 00
    rozbieznosc:    < 1 mrad
    izolator optyczny na wyjsciu

Uklad do generacji drugiej harmonicznej sklada sie z krysztalu PPLN utrzymywanego w ustalonej temperaturze, rozbudowanego ukladu optycznego, 
w sklad którego wchodza lustra w precyzyjnych uchwytach, soczewki, plytki fazowe, polaryzatory, izolatory optyczne oraz ukladu stabilizacji 
(LB1005 Servo Controller firmy New Focus). Laser pozwala na uzyskanie promieniowania laserowego o duzej mocy i wysmienitej przestrzennej 
charakterystyce wiazki laserowej. Dzieki temu moze byc wykorzystany wszedzie tam, gdzie potrzebne jest uzyskanie duzej koncentracji mocy. 
Z drugiej strony laser charakteryzuje sie bardzo waska spektralnie linia, co, po wytworzeniu drugiej harmonicznej, pozwala na wykorzystanie 
do precyzyjnej spektroskopii atomowej, chodzenia i pulapkowania atomów.',
    (SELECT id FROM Projekt WHERE nazwa="ATOMIN"),
  (SELECT id FROM Laboratorium WHERE nazwa='Laboratorium Diagnostyki Fotonicznej')
  );
  
INSERT INTO Sprzet(nazwa, data_zakupu, data_uruchom, wartosc, opis, projekt, laboratorium)
  VALUES(
  'Lasery diodowe z zewnetrznym rezonatorem',
  '2010-11',
  '2010-11',
  28056340, 
  'Uklad sklada sie z trzech laserów diodowych wyprodukowanych przez firme Sacher Lasertechnik: 
dwóch laserów typu Lynx-TEC-120-0780-150 i jednego typu Lion-TEC-520-0780-100.
Parametry laserów typu Lynx (typu Lion):

    laser jednomodowy pracy ciaglej,
    zakres dlugosci fali 770-795 nm,
    moc 150 mW (100 mW),
    zakres przestrajania 25 nm,
    przestrajanie bez przeskoku modu 30 GHZ (50 GHz),
    szerokosc spektralna typowo <1 MHz (<0,5 MHz).

Lasery wyposazone sa w dwustopniowy izolator optyczny na wyjsciu, dodatkowe wyjscie wiazki do stabilizacji czestosci laserów, 
uklad sterownika pradu lasera i stabilizacji temperatury oraz uklad szybkiej stabilizacji czestosci lasera.',
    (SELECT id FROM Projekt WHERE nazwa="ATOMIN"),
  (SELECT id FROM Laboratorium WHERE nazwa='Laboratorium Diagnostyki Fotonicznej')
  );
  
INSERT INTO Sprzet(nazwa, data_zakupu, data_uruchom, wartosc, opis, projekt, laboratorium)
  VALUES(
  'Mikroskop konfokalny (mikroskop odwrócony Nikon Ti-E z systemem konfokalnym Nikon A1)',
  '2009-11',
  '2009-11',
  119915858, 
  'System sklada sie z:

    odwróconego mikroskopu optycznego wyposazonego w piec obiektywów plan fluorytowych o powiekszeniach 4x, 10x, 20x, 40x, 100x oil 
oraz trzy bloki filtrów fluorescencyjnych do barwników: DAPI, FITC, TRITC;
    skanera konfokalnego posiadajacego cztery niezalezne kanaly detekcyjne (fotopowielacze) dla fluorescencji oraz dodatkowy detektor swiatla przechodzacego;
    skanera spektralnego 32-kanalowego zbierajacego widma fluorescencji o zmiennej rozdzielczosci (2,5 nm, 6 nm, 10 nm);
    zestawu czterech laserów diodowych o liniach spektralnych: 405 nm, 488 nm, 561 nm, 638 nm;
    oprogramowania NIS-Elements do sterowania mikroskopem z systemem konfokalnym oraz analizy otrzymanych mikrogramów.

Zakupiony mikroskop konfokalny umozliwia obrazowanie fluoryzujacych obiektów o rozmiarach wiekszych od 1 µm. Mozliwa jest rejestracja 
widm fluoryzujacych obiektów, a takze pomiary intensywnosci fluorescencji w wybranym obszarze obrazu i/lub w czasie, tworzenie wirtualnych 
przekrojów poprzecznych i podluznych, analiza widma fluorescencji w szerokim zakresie dlugosci fal, FRET, FRAP, kolokalizacja, fotoaktywacja.',
    (SELECT id FROM Projekt WHERE nazwa="ATOMIN"),
  (SELECT id FROM Laboratorium WHERE nazwa='Laboratorium Mikroskopii Konfokalnej i Elipsometrii')
  );
  
INSERT INTO Sprzet(nazwa, data_zakupu, data_uruchom, wartosc, opis, projekt, laboratorium)
  VALUES(
  'System lasera OPO: optyczny oscylator parametryczny z laserem pompujacym',
  '2011-04',
  '2001--04',
  30707400, 
  'System sklada sie z:

    nanosekundowego lasera pompujacego typu Nd:YAG o czasie trwania 3 ns (@1064nm) i energii w impulsie do 250 mJ. 
Laser dziala w pojedynczym modzie podluznym co daje waska spektralnie linie laserowa o szerokosci (FWHM) nie przekraczajacej 0.01 cm-1. 
Ponadto, uklad wyposazony jest w generator drugiej harmonicznej (532 nm), której energia osiaga 120 mJ.
    optycznego oscylatora parametrycznego (OPO), który pompowany laserem Nd:YAG emituje promieniowanie w zakresie 420-2300 nm, 
o energii 1-20 mJ (w zaleznosci od zakresu) i szerokosci spektralnej nie wiekszej niz 2 cm-1. Przestrajanie dlugosci fali OPO 
i kontrola parametrów jego pracy odbywaja sie za pomoca komputera.


System OPO wraz z laserem pompujacym pozwalaja na prowadzenie badan z zakresu spektroskopii laserowej, optyki kwantowej, optyki nieliniowej 
i fotoniki w zakresie widzialnym i bliskiej podczerwieni. Ponadto moze byc wykorzystywany w badaniach z zakresu zawansowanych materialów, 
fizyki medycznej, biofizyki i biotechnologii.',
    (SELECT id FROM Projekt WHERE nazwa="ATOMIN"),
  (SELECT id FROM Laboratorium WHERE nazwa='Laboratorium Diagnostyki Fotonicznej')
  );
  
INSERT INTO Sprzet(nazwa, data_zakupu, data_uruchom, wartosc, opis, projekt, laboratorium)
  VALUES(
  'Oprogramowanie do obliczen kwantowochemicznych obejmujace pakiety Gaussian 09 oraz QChem',
  '2010-06',
  '2010-06',
  4705189, 
  'Oprogramowanie Gaussian 09 implementuje standardowe metody chemii kwantowej: metody pólempiryczne, DFT, HF, metody post-HF (MP, CC, CI, CASSCF) 
umozliwiajac obliczanie energii i optymalizacje geometrii ukladów oraz badanie wlasnosci molekularnych (np. analiza populacyjna, momenty multipolowe, 
polaryzowalnosci) i spektroskopowych (drgania normalne, wzbudzone stany elektronowe, parametry NMR i EPR). 
W przypadku wielu metod mozliwe jest uwzglednienie modelu rozpuszczalnika PCM. Zainstalowana wersja pozwala na równolegle wykorzystanie wielu rdzeni 
na pojedynczym wezle klastra. QChem 3.2 jest oprogramowaniem do obliczen kwantowochemicznych umozliwiajacym wykonywanie obliczen energii, geometrii, 
wlasnosci molekularnych i spektroskopowych typowymi metodami chemii kwantowej (HF, post-HF, DFT). W przypadku obliczen MP2 mozliwe jest 
wykorzystanie metodologii local-MP2 lub RI MP2 redukujacej czas obliczen. Unikalnymi cechami programu QChem jest implementacja metodologii spin-flip DFT 
oraz Equation of Motion CCSD. Obliczenia programem QChem 3.2 moga byc wykonywane równolegle z wykorzystaniem wielu wezlów klastra.',
    (SELECT id FROM Projekt WHERE nazwa="ATOMIN"),
  (SELECT id FROM Laboratorium WHERE nazwa='Laboratorium Modelowania Molekularnego')
  );
  
INSERT INTO Sprzet(nazwa, data_zakupu, data_uruchom, wartosc, opis, projekt, laboratorium)
  VALUES(
  'Spektrometr oraz kamera CCD ze wzmacniaczem obrazu (Princeton Instruments)',
  '2010-02',
  '2010-02',
  29130441, 
  'Zestaw sklada sie z:

    Spektrometru wyposazonego w trzy siatki dyfrakcyjne o liczbie rys/mm 150, 1200 i 2400. Spektrometr dziala w zakresie od 180nm do 900nm, 
jego maksymalna zdolnosc rozdzielcza wynosi 0.03nm.
    Kamery CCD ze wzmacniaczem obrazu. Powierzchnia elementu swiatloczulego wynosi 18mmx18mm, 1024x1024 pikseli, 
rozmiar pojedynczego piksela: 13µm x 13µm. Stosujac uklad bramkowania impulsowego mozna rejestrowac procesy dynamiczne z minimalna czasowa 
zdolnoscia rozdzielcza ponizej 2ns. Zakres spektralny kamery wynosi 200-850nm, komunikacja odbywa sie przez port USB.

Zestaw spektrometru i kamery stanowi narzedzie umozliwiajace badania z zakresu spektroskopii, optyki kwantowej, 
optyki nieliniowej i fotoniki w bardzo szerokim zakresie, a ponadto moze byc wykorzystywany w badaniach z zakresu zawansowanych materialów, 
fizyki medycznej, biofizyki i biotechnologii.',
    (SELECT id FROM Projekt WHERE nazwa="ATOMIN"),
  (SELECT id FROM Laboratorium WHERE nazwa='Laboratorium Diagnostyki Fotonicznej')
  );
 
 /*
INSERT INTO Sprzet(nazwa, data_zakupu, data_uruchom, wartosc, opis, projekt, laboratorium)
  VALUES(
  '',
  '',
  '',
  , --''
  '',
    (SELECT id FROM Projekt WHERE nazwa="ATOMIN"),
  (SELECT id FROM Laboratorium WHERE nazwa='')
  );
*/  
