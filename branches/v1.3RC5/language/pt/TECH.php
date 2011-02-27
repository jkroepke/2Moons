<?php

/**
 *  2Moons
 *  Copyright (C) 2011  Slaver
 *
 * This program is free software: you can redistribute it and/or modify
 * it under the terms of the GNU General Public License as published by
 * the Free Software Foundation, either version 3 of the License, or
 * (at your option) any later version.
 *
 * This program is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 * GNU General Public License for more details.
 *
 * You should have received a copy of the GNU General Public License
 * along with this program.  If not, see <http://www.gnu.org/licenses/>.
 *
 * @package 2Moons
 * @author Slaver <slaver7@gmail.com>
 * @copyright 2009 Lucky <douglas@crockford.com> (XGProyecto)
 * @copyright 2011 Slaver <slaver7@gmail.com> (Fork/2Moons)
 * @license http://www.gnu.org/licenses/gpl.html GNU GPLv3 License
 * @version 1.3 (2011-01-21)
 * @link http://code.google.com/p/2moons/
 */

//SHORT NAMES FOR COMBAT REPORTS
$LNG['tech_rc'] = array (
202 => 'Cg.Pequeno',
203 => 'Cg.Grande',
204 => 'Caça L.',
205 => 'Caça P.',
206 => 'Cruzador',
207 => 'N.Batalha',
208 => 'N. Colonização',
209 => 'Reciclador',
210 => 'Sonda',
211 => 'Bombardeiro.',
212 => 'Sat.Solar',
213 => 'Destruidor',
214 => 'E. da Morte',
215 => 'Interceptor',
216 => "E.Destruidora",
217 => 'Evo.Transportador',
218 => 'Avatar',
219 => 'Giga.Reciclador',
220 => 'Sondador de MN',


401 => "L.Misseis.",
402 => "Laser L.",
403 => "Laser P.",
404 => "C.Gauss",
405 => "C.Iões",
406 => "C.Plasma",
407 => "P.Escudo",
408 => "G.Escudo",
409 => 'Gigantic signpost dome',
410 => 'C.Gravitação',
411 => 'S.Orbital',
);



$LNG['tech'] = array(
 0 => "Edifícios",
 1 => "Mina de metal",
 2 => "Mina de cristal",
 3 => "Extractor de deutério",
 4 => "Planta de energia solar",
 6 => 'TechnoDome',
12 => "Planta de fusão",
14 => "Fábrica de robots",
15 => "Fábrica de nanites",
21 => "Hangar",
22 => "Armazém de Metal",
23 => "Armazém de Cristal",
24 => "Tanque de Deutério",
31 => "Laboratório de Pesquisas",
33 => "Terra-Formador",
34 => "Depósito da aliança",
44 => "Silo de Mísseis",

40 => 'Edifícios especiais',
41 => 'Base lunar',
42 => 'Sensor Phalanx',
43 => 'P. de Salto Quântico',


// Tecnologias
100 => 'Pesquisas',
106 => 'Tecnologia de Espionagem',
108 => 'Tecnologia de Computadores',
109 => 'Tecnologia de Armas',
110 => 'Tecnologia de Escudo',
111 => 'Tecnologia de Blindagem',
113 => 'Tecnologia de Energia',
114 => 'Tecnologia de Hiperespaço',
115 => 'Motor de Combustão',
117 => 'Motor de Impulsão',
118 => 'Motor Propulsor de Hiperespaço',
120 => 'Tecnologia Laser',
121 => 'Tecnologia de Iões',
122 => 'Tecnologia de Plasma',
123 => 'Rede Intergaláctica de Pesquisas',
124 => 'Exploração Espacial',
131 => 'Maximização da produção de Metal',
132 => 'Maximização da produção de Cristal',
133 => 'Maximização da produçao de Deutério',
199 => 'Tecnologia de Gravitação',

200 => "Naves",
202 => "Cargueiro Pequeno",
203 => "Cargueiro Grande",
204 => "Caça Ligeiro",
205 => "Caça Pesado",
206 => "Cruzador",
207 => "Nave de Batalha",
208 => "Nave de Colonização",
209 => "Reciclador",
210 => "Sonda de Espionagem",
211 => "Bombardeiro",
212 => "Satélite Solar",
213 => "Destruidor",
214 => "Estrela da morte",
215 => "Interceptor",
216 => "Estrela Destruidora",
217 => 'Evo. Transportador',
218 => 'Avatar',
219 => 'Giga. Reciclador',
220 => 'Sondador de MN',


400 => 'Sistemas de Defesa',
401 => 'Lançador de Mísseis',
402 => 'Laser Ligeiro',
403 => 'Laser Pesado',
404 => 'Canhão de Gauss',
405 => 'Canhão de Iões',
406 => 'Canhão de Plasma',
407 => 'P. Escudo Planetário',
408 => 'G. Escudo Planetário',
409 => 'Gigantic signpost dome',
410 => 'Canhão de Gravitação',
411 => 'S. Orbital de Defesa',

502 => 'Míssil de Intercepção',
503 => 'Míssil Interplanetário',

600 => 'Oficiais',
601 => 'Geólogo',
602 => 'Almirante',
603 => 'Engenheiro',
604 => 'Tecnocrata',
605 => 'Constructor',
606 => 'Cientista',
607 => 'Especialista de Armazenamento',
608 => 'Ministro da Defesa',
609 => 'Guardião',
610 => 'Espião',
611 => 'Comandante',
612 => 'Destruidor',
613 => 'General',
614 => 'Conquistador',
615 => 'Imperador',

700 => 'Optimização de Armas',
701 => 'Optimização de Escudos',
702 => 'Coordenação na construção',
703 => 'Optimização de Recursos',
704 => 'Optimização de Energia',
705 => 'Optimização de Pesquisas',
706 => 'Coordenação de Frotas',
);

$LNG['res']['descriptions'] = array(
1 => "As minas de metal constituem o principal produtor de matéria-prima para a construção de edifícios e de naves espaciais.",
2 => "As minas de cristal constituem o principal produtor de matéria-prima para a elaboração de circuitos eléctricos e na estrutura dos componentes de ligas.",
3 => "O deutério é usado como combustível para naves espaciais. Colhido no mar profundo, o deutério é uma substância rara e é assim relativamente caro.",
4 => "As plantas de energia solar convertem a energia solar em energia eléctrica para o uso das minas, estruturas e algumas pesquisas.",
6 => "Cada nível da universidade reduz o tempo das pesquisas em 8%.",
12 => "Em plantas de fusão, os núcleos de hidrogénio são fundidos em núcleos de hélio sobre uma enorme temperatura e pressão, libertando uma quantidade enorme de energia.",
14 => "A fábrica de robots fornece unidades baratas e competentes na construção que podem ser usadas para construir ou promover toda a estrutura planetária. Cada evolução para um nível superior desta fábrica aumenta a eficiência e o número das unidades que ajudam e diminuem o tempo de construção.",
15 => "Os nanites são unidades robóticas minúsculas com um tamanho médio apenas de alguns nanómetros. Estes micróbios mecânicos são ligados entre si e programados para uma tarefa da construção, oferecendo assim uma velocidade de construção única.",
21 => "O hangar é responsável pela construção de naves espaciais e de sistemas de defesa.",
22 => "Cada evolução do armazém de metal permite o aumento da capacidade de armazenamento.",
23 => "Cada evolução do armazém de cristal permite o aumento da capacidade de armazenamento.",
24 => "Os tanques de deutério são tanques de armazenamento enormes.",
31 => "Para ser capaz de pesquisar e evoluir na área das tecnologias, é necessária a construção de um laboratório de pesquisas.",
33 => "O Terra-Formador permite aumentar o número de áreas disponíveis para no construção do planeta.",
34 => "O depósito da aliança permite às frotas da aliança a possibilidade de reabastecer.",
41 => "Sabendo que uma lua não possui atmosfera, uma base lunar é necessária para criar um espaço habitável.",
42 => "Um dispositivo de alta resolução do sensor é utilizado para espiar um espectro de frequência.",
43 => "O Portal de Salto Quântico é um transceptor enorme capaz de transportar instantaneamente uma frota inteira para outro portal de salto.",
44 => "O silo de mísseis é a estrutura de lançamento e armazenamento dos mísseis.",

106 => "A tecnologia de espionagem resulta de pesquisas sobre sensores de dados, equipamento e conhecimento da inteligência de que um império necessita para se proteger de ataques, mas também para dirigir ataques contra o inimigo.",
108 => "A informática é utilizada para construir processos de dados cada vez mais evoluídos e controlar unidades.",
109 => "A tecnologia de armas trata do desenvolvimento dos sistemas de armas existentes. É focalizada principalmente no aumento do poder e da eficiência das armas.",
110 => "A tecnologia de escudo é utilizada para criar um escudo protector. Cada evolução do nível desta tecnologia aumenta a protecção em 10%",
111 => "Para uma dada liga que provou ser eficaz, a estrutura molecular pode ser alterada de maneira a manipular o seu comportamento numa situação de combate e incorporar as realizações tecnológicas.",
113 => "A tecnologia de energia trata do conhecimento das fontes de energia, das soluções de armazenamento e das tecnologias que fornecem o que é mais básico: Energia.",
114 => "A tecnologia de hiperespaço fornece o conhecimento para as viagens no hiperespaço utilizadas por muitas naves de guerra.",
115 => "Os motores de combustão pertencem aos motores antigos e são baseados na repulsão. As partículas são aceleradas deixando o motor criar uma força repulsiva que move a nave no sentido oposto.",
117 => "Uma grande parte de matéria repulsada resulta em restos e lixo criados pela fusão nuclear. Cada evolução desta tecnologia aumenta em 20% a velocidade das naves mais pesadas como o cruzador, bombardeiro, caça pesado e nave de colonização.",
118 => "O motor propulsor é baseado na curvatura do espaço-tempo. Desta maneira, o ambiente das naves que utilizam este motor propulsor comprime-se, permitindo que as naves percorram grandes distãncias em muito pouco tempo.",
120 => "O laser (amplificação de luz pela emissão estimulada da radiação) cria um raio intenso de luz, que concentra uma grande quantidade de energia.",
121 => "Ao acelerar iões é criado um raio letal que causa danos importantes aos objectos que atinge.",
122 => "Tecnologia mais avançada que a tecnologia de iões que, em vez de acelerar iões, acelera o plasma com um grande poder energético. Desta forma cria-se um raio que ocasiona danos enormes aos objectos que atinge.",
123 => "Os cientistas dos teus planetas podem comunicar uns com os outros graças a esta rede.",
124 => "A tecnologia de Exploração Espacial inclui formas de pesquisa à distância e permite o uso de módulos de pesquisa nas naves. Estes últimos são compostos por uma base de dados funcional num laboratório móvel.",
131 => 'Aumentar a procução da mina de metal por 2%',
132 => 'Aumentar a produção da mina de cristal por 2%',
133 => 'Aumentar a produção do sintetizador de deuterio por 2%',
199 => "Um gráviton é uma partícula elementar responsável pelos efeitos da gravitação.",

202 => "Estas naves são aproximadamente do tamanho de uma nave de combate, mas não são equipadas nem com motores nem com armamento de combate, para deixar mais espaço para os recursos a transportar.",
203 => "Esta nave não deve atacar sozinha, pois a sua estrutura não lhe permite resistrir muito tempo aos sistemas de defesa.",
204 => "Considerando a sua estrutura, agilidade e alta velocidade, o caça ligeiro pode ser definido como uma boa arma no principio do jogo, e um bom acompanhante para as naves mais sofisticadas e poderosas.",
205 => "Durante a evolução do caça ligeiro os investigadores chegaram ao ponto onde a tecnologia convencional alcança os seus limites.",
206 => "Com os lasers pesados e os canhões do iões que emergem nos campos de batalha, as naves básicas de combate encontravam cada vez mais em dificuldade.",
207 => "As naves de batalha constituem a espinha dorsal de qualquer frota militar. Os sistemas de armas poderosos e a resistência inigualável da nave de batalha adicionados à alta velocidade e à capacidade de carga importante fazem desta nave um perigo constante, em qualquer situação e contra qualquer oponente.",
208 => "Esta nave permite colonizar novos planetas, outros mundos, onde nenhum homem ainda se aventurou no passado.",
209 => "Os combates no espaço parecem tornar-se cada vez mais impressionantes onde numa única batalha milhares de naves podem ser destruídas e os restos perdidos para sempre.",
210 => "As sondas de espionagem são drones com uma rapidez impressionante de propulsão utilizados para espiar os inimigos.",
211 => "O bombardeiro é uma nave espacial desenvolvida para destruir os sistemas de defesa planetários mais recentes e poderosos.",
212 => "Os satélites solares são satélites simples situados na órbita de um planeta, equipados de células fotovoltaicas, capazes de transferir energia para o planeta.",
213 => "Com o destruidor, a mãe de todas as naves entra na arena. O sistema de armas desta nave é constituído por canhões de ion-plasma e canhões de Gauss, adicionando um sistema de detecção e escolha de alvo, a nave pode destruir caças ligeiros voando em plena velocidade com 99% de probabilidade.",
214 => "Uma embarcação deste tamanho e deste poder necessita uma quantidade gigantesca de recursos e mão de obra que podem ser fornecidos somente pelos impérios mais importantes de todo o universo.",
215 => "Esta nave, uma filigrana tecnológica, é mortal na altura de destruir frotas inimigas.",
216 => 'O sucessor das populares estrelas da morte, um pouco mais rápido e mais forte, devido ao seu melhor armamento e motores.',
217 => 'Este é o sucessor do cargeiro grande, o Evo. Transportador, com uma capacidade de carga muito acima do normal, e mais rápido que o seu anterior, faz desta nave um supremo monstro de carga.',
218 => 'Esta pode ser chamada a nave de destruição mas nem tudo são vantagens, o seu tamanho faz desta nave um monstro lento.',
219 => 'O Giga.Reciclador é uma nave muito desejada devido à sua capacidade de carga e velocidade.',
220 => 'Após longos anos de pesquisas, foi possivel criar a nave que rastreia matéria negra .',

401 => "O lançador de mísseis é um sistema de defesa simples e barato. Tornam-se muito eficazes em número e podem ser construídos sem pesquisa específica porque é uma arma de balística simples.",
402 => "Para acompanhar o ritmo com a velocidade sempre crescente do desenvolvimento das tecnologias de naves espaciais, os cientistas tiveram que criar um tipo novo de sistema da defesa capaz de destruír as naves mais fortes.",
403 => "O laser pesado é uma evolução directa do laser ligeiro, a integridade estrutural foi evoluída e aumentada e materiais novos foram adoptados.",
404 => "Durante muito tempo pensou-se que as armas de projécteis iam ser como a tecnologia de fusão e de energia, o desenvolvimento da propulsão de hiperespaço e o desenvolvimento de protecções melhoradas ficando antigas até que a tecnologia de energia, que a tinha posta de lado naquele tempo, as fez renascer.",
405 => "No século XXI existiu algo com o nome de PEM. O PEM era um pulso eletromagnético que causava uma tensão adicional em cada circuito, o que provocava muitos incidentes de obstrução nos instrumentos mais sensíveis.",
406 => "A tecnologia de laser foi melhorada, a tecnologia de iões alcançou a sua fase final. Pensou-se que seria impossível criar sistemas de armas mais eficazes. A possibilidade de combinar os dois sistemas mudou este pensamento.",
407 => "Muito tempo antes da instalação dos escudos em embarcações, os geradores já existiam na superfície dos planetas. Cobriam os planetas e eram capazes de absorver quantidades enormes de danos antes de serem destruídos.",
408 => "O grande escudo planetário cobre o planeta para absorver quantidades enormes de tiros.",
409 => 'A evolução da tecnologia do Grande escudo planetario. Consome muito mais energia mas é capaz de aguentar um numero bem maior de ataques.',
410 => 'Após anos de pesquisa sobre a força gravitacional os pesquisadores desenvolveram um Canhão de Gravitação que produz pequenos Gravitões concentrados e podem ser disparados contra o inimigo..',
411 => 'Esta plataforma de proporções gigantescas, as maiores, que foram alguma vez vistas no universo. É uma plataforma imovél defensiva. Não tem accionamento directo e é realizada por Graviton.',

502 => "O míssil de intercepção destrói os mísseis interplanetários atacantes.",
503 => "O míssil interplanetário destrói os sistemas de defesa do inimigo.",

700 => 'Aumenta o valor do ataque das naves em %s%%. Este bonús é temporário.',
701 => 'Aumenta o valor dos escudos e defesas das navem em %s%%. Este bonús é temporário.',
702 => 'Diminui o tempo da construção de edificios em %s%%. Este bonús é temporário.',
703 => 'Aumenta a produção de recursos em %s%%. Este bonús é temporário.',
704 => 'Aumenta a produção de energia em %s%%. Este bonús é temporário.',
705 => 'Encurta o tempo de pesquisa em %s%%. Este bonús é temporário.',
706 => 'Encurta o tempo de voo em %s%%. Este bonús é temporário. Não afecta expedições.',
);


// ----------------------------------------------------------------------------------------------------------
// Minen Gebäude
$LNG['info'][1]['name']          = "Mina de Metal";
$LNG['info'][1]['description']   = "As minas de metal constituem o principal produtor de matéria-prima para a construção de edifícios e de naves espaciais. O metal é o material mais barato mas também o mais utilizado. A produção de metal necessita pouca energia. O metal encontra-se a grandes profundidades na maioria dos planetas. A evolução de uma mina de metal tornará a mina maior, mais profunda, aumentando a produção.";
$LNG['info'][2]['name']          = "Mina de Cristal";
$LNG['info'][2]['description']   = "As minas de cristal constituem o principal produtor de matéria-prima para a elaboração de circuitos eléctricos e na estrutura dos componentes de ligas. A produção de cristal necessita o dobro da energia comparado com a produção de metal, assim o cristal é um material mais caro. Todos os edifícios e naves espaciais utilizam cristal. Infelizmente o cristal é raro e só se encontra em grandes profundidades. Para aumentar a produção de cristal, e assim obter cristais maiores e mais puros, é indispensável evoluir as minas de cristal.";
$LNG['info'][3]['name']          = "Extractor de Deutério";
$LNG['info'][3]['description']   = "O deutério é água pesada - o núcleo do hidrogénio contém um neutrão adicional, sendo um excelente combustível para as naves devido ao elevado rendimento energético da reacção. O deutério pode ser encontrado frequentemente no mar profundo devido ao seu peso molecular. Evoluir o extractor de deutério permite recolher maior quantidade deste recurso.";

// ----------------------------------------------------------------------------------------------------------
// Energie Gebäude
$LNG['info'][4]['name']          = "Planta de Energia Solar";
$LNG['info'][4]['description']   = "Para fornecer a energia necessária ao bom funcionamento das minas, são necessárias grandes plantas de energia solar. A planta de energia solar é uma das maneiras para criar energia. A superfície das células fotovoltaicas, capazes de transformar a energia solar em energia eléctrica, aumenta com a evolução da planta de energia solar. A planta de energia solar é uma estrutura indispensável para o estabelecimento e uso de energia num planeta.";
$LNG['info'][12]['name']         = "Planta de Fusão";
$LNG['info'][12]['description']  = "Em plantas de fusão, os núcleos de hidrogénio são fundidos em núcleos de hélio sobre uma enorme temperatura e pressão, libertando uma quantidade enorme de energia. Para cada grama de Deutério consumido, pode ser produzido até 41,32*10^-13 joules de energia; Com 1g és capaz de produzir 172MWh de energia.<br/><br/>Maiores reactores usam mais deutério e podem produzir mais energia por hora. O efeito da energia pode ser aumentado pesquisando a tecnologia de energia.<br/><br/>A produção de energia da planta de fusão é calculada da seguinte forma:</br>30 * [Nível da planta de fusão] * (1,05 + [Nível da tecnologia de energia] * 0,01) ^ [Nível da planta de fusão]";

// ----------------------------------------------------------------------------------------------------------
// Gebäude
$LNG['info'][6]['name']          = "TechnoDome";
$LNG['info'][6]['description']   = "Os cientistas juntaram-se para criar uma forma de poderem reduzir o tempo das pesquisas, então criaram a universidade que por cada nivel irá reduzir o tempo de construção das pesquisas em 8%.";
$LNG['info'][14]['name']         = "Fábrica de Robots";
$LNG['info'][14]['description']  = "A fábrica de robots fornece unidades baratas e competentes na construção que podem ser usadas para construir ou promover toda a estrutura planetária. Cada evolução para o nível superior desta fábrica aumenta a eficiência e o número das unidades que ajudam e diminuem o tempo de construção.";
$LNG['info'][15]['name']         = "Fábrica de Nanites";
$LNG['info'][15]['description']  = "Os nanites são unidades robóticas minúsculas com um tamanho médio apenas de alguns nanómetros. Estes micróbios mecânicos são ligados entre si e programados para uma tarefa da construção, oferecendo assim uma velocidade de construção única. Os nanites operam a nível molecular, cada evolução reduz para metade o tempo de construção dos edifícios, das naves espaciais e das estruturas planetárias de defesa.";
$LNG['info'][21]['name']         = "Hangar";
$LNG['info'][21]['description']  = "O hangar é responsável pela construção de naves espaciais e de sistemas de defesa. A evolução do hangar permite a produção de uma mais larga variedade de naves e de sistemas de defesa e a diminuição do tempo de construção.";
$LNG['info'][22]['name']         = "Armazém de Metal";
$LNG['info'][22]['description']  = "Cada evolução do armazém de metal permite o aumento da capacidade de armazenamento. Se a capacidade máxima do armazém é atingida, a produção de metal é interrompida.";
$LNG['info'][23]['name']         = "Armazém de Cristal";
$LNG['info'][23]['description']  = "Cada evolução do armazém de cristal permite o aumento da capacidade de armazenamento. Se a capacidade máxima do armazém é atingida, a produção de cristal é interrompida.";
$LNG['info'][24]['name']         = "Tanque de Deutério";
$LNG['info'][24]['description']  = "Os tanques de deutério são tanques de armazenamento enormes. Estes tanques encontram-se frequentemente perto dos hangares planetários, sendo o deutério usado como combustível. Uma vez que a capacidade máxima de tanque é atingida, a produção de deutério é interrompida.";
$LNG['info'][31]['name']         = "Laboratório de Pesquisas";
$LNG['info'][31]['description']  = "Para ser capaz de pesquisar e evoluir na área das tecnologias, é necessária a construção de um laboratório de pesquisas. A evolução do nível do laboratório aumenta a velocidade de aprendizagem das tecnologias, mas abre também ao ensino e pesquisa de novas tecnologias. De maneira a poder realizar a pesquisa o mais rapidamente poss�vel, os cient�ficos escolhem o planeta mais evoluído e regressam depois ao planeta de origem com o conhecimento. De esta forma, é possível introduzir as novas tecnologias em todos os planetas do império e oferece novas pesquisas.";
$LNG['info'][33]['name']         = "Terra-Formador";
$LNG['info'][33]['description']  = "O Terra-Formador permite aumentar o número de áreas disponíveis para construção do planeta. Graças a este processo, um planeta pode aumentar a sua capacidade, e espaço. Com o tempo, o espaço tende a ser insuficiente e vários métodos já utilizados eram insuficientes ou inúteis a longo prazo.<br/>Um grupo de cientistas e nano-tecnicos encontraram uma solu��o: Criar e formar Terra (Terra-Formador).<br/>Com muita energia, é possivel criar continentos inteiros!<br/>Nanitas especiais são produzidos neste edifício para assegurar a qualidade e a usabilidade das áreas formadas pelo Terra-Formador.";
$LNG['info'][34]['name']         = "Depósito da Aliança";
$LNG['info'][34]['description']  = "O depósito da aliança permite ás frotas da aliança a possibilidade de reabastecer. Cada evolução do depósito fornece ás frotas em órbita 10.000 unidades adicionais de deutério por hora.";


// ----------------------------------------------------------------------------------------------------------
// Mond Gebäude
$LNG['info'][41]['name']         = "Base Lunar";
$LNG['info'][41]['description']  = "Sabendo que uma lua não possui atmosfera, uma base lunar é necessaria para criar um espaço habitável. A base lunar fornece oxigenio mas também gravitação artificial, e proteção. Cada evolução da base lunar aumenta o tamanho da área para construção de estruturas. Cada nível fornece 3 campos lunares, até a lua estar cheia.";
$LNG['info'][42]['name']         = "Sensor Phalanx";
$LNG['info'][42]['description']  = "Um dispositivo de alta resolução do sensor é utilizado para espiar um espectro de frequência. As variações de energia mostram informações sobre o movimento de frotas. Para realizar uma varredura é necessária uma quantidade de energia sob forma de deutério disponível na lua.";
$LNG['info'][43]['name']         = "Portal de Salto Quântico";
$LNG['info'][43]['description']  = "O Portal de Salto Quântico é um transceptor enorme capaz de transportar instantaneamente uma frota inteira para outro portal de salto. O transmissor não necessita de Deutério para funcionar, mas precisa de arrefecer durante 1 hora entre saltos. Não é possível transportar recursos pelo portal. Todo o equipamento é feito de tecnologia de ponta.";
$LNG['info'][44]['name']         = "Silo de Mísseis";
$LNG['info'][44]['description']  = "O silo de mísseis é a estrutura de lançamento e armazenamento dos mésseis. Tem o espaço para 5 mísseis interplanetários ou 10 mísseis de intercepção por cada nível evoluído.";

// ----------------------------------------------------------------------------------------------------------
// Forschung
$LNG['info'][106]['name']        = 'Tecnologia de Espionagem';
$LNG['info'][106]['description'] = 'A tecnologia de espionagem resulta de pesquisas sobre sensores de dados, equipamento e conhecimento da inteligência de que um império necessita para se proteger de ataques, mas também para dirigir ataques contra o inimigo. A evolução desta tecnologia aumenta os detalhes, e informações obtidos.<br/><br/>O resultado de espionagem depende também da força e do nível de espionagem do jogador adverso. A evolução do nível da tecnologia de espionagem define também o nível dos detalhes sobre uma frota que se aproxima do teu planeta:<br/>- Nível 2 adiciona o número de naves á informação sobre a frota;<br/>- Nível 4 adiciona o tipo das naves que se aproximam;<br/>- Nível 8 adiciona finalmente detalhes sobre o tipo e o número de naves que se aproximam.</br><br/>Em geral, a tecnologia de espionagem é muito importante para um império, seja ele agressivo ou amigável. Conselho: começar a pesquisar esta área tecnológica logo depois de ter á sua disposição as primeiras naves de transporte.';
$LNG['info'][108]['name']        = 'Tecnologia de Computadores';
$LNG['info'][108]['description'] = 'A informática é utilizada para construir processos de dados cada vez mais evoluídos e controlar unidades. Cada evolução desta tecnologia aumenta o número de frotas que podem ser comandadas em mesmo tempo. Aumentando esta tecnologia, permite mais actividade e assim um melhor rendimento, isso tomando em conta as frotas militares assim como transportes de carga e espionagem. Será uma boa ideia aumentar constantemente a pesquisa nesta área para fornecer uma flexibilidade adequada ao império.';
$LNG['info'][109]['name']        = 'Tecnologia de Armas';
$LNG['info'][109]['description'] = 'A tecnologia de armas trata do desenvolvimento dos sistemas de armas existentes. é focalizada principalmente no aumento do poder e da eficiência das armas.<br/>Com esta tecnologia, e aumentando o seu nível, a mesma arma tem mais poder e causa mais danos - cada nível aumenta o poder de fogo em 10%.<br/>A tecnologia de armas é importante permanecer a um nível elevado, para não facilitar a tarefa dos inimigos.';
$LNG['info'][110]['name']        = 'Tecnologia de Escudo';
$LNG['info'][110]['description'] = 'A tecnologia de escudo é utilizada para criar um escudo protector. Cada evolução do nível desta tecnologia aumenta a protecção em 10%. O nível do melhoramento aumenta basicamente a quantidade de energia que o escudo pode absorver antes de ser destruido. Esta tecnologia não só aumenta a qualidade dos escudos das naves, como também do escudo protector planetário.';
$LNG['info'][111]['name']        = 'Tecnologia de Blindagem';
$LNG['info'][111]['description'] = 'Para uma dada liga que provou ser eficaz, a estrutura molecular pode ser alterada de maneira a manipular o seu comportamento numa situação de combate e incorporar as realizações tecnológicas. Cada evolução do nível desta tecnologia aumenta a blindagem em 10%.';
$LNG['info'][113]['name']        = 'Tecnologia de Energia';
$LNG['info'][113]['description'] = 'A tecnologia da energia trata do conhecimento das fontes de energia, das soluções de armazenamento e das tecnologias que fornecem o que é mais básico: Energia. São necessários determinados níveis de evolução desta tecnologia para permitir o acesso a novas tecnologias que confiam no conhecimento da energia.';
$LNG['info'][114]['name']        = 'Tecnologia de Hiperespaço';
$LNG['info'][114]['description'] = 'A tecnologia de hiperespaço fornece o conhecimento para as viagens no hiperespaço utilizadas por muitas naves de guerra. é uma nova e complicada espécie de tecnologia que requer um equipamento caro de laboratório e facilidades de testes.';
$LNG['info'][115]['name']        = 'Motor de Combustão';
$LNG['info'][115]['description'] = 'Os motores de combustão pertencem aos motores antigos e são baseados na repulsão. As partículas são aceleradas deixando o motor criar uma força repulsiva que move a nave no sentido oposto. A eficiência destes motores de combustão é baixa, mas são baratos e de confiança.<br/>Pesquisar e evoluir esta tecnologia aumenta a velocidade de combustão dos motores e assim a velocidade das naves, cada evolução aumenta a velocidade em 10%. Esta tecnologia é de grande importãncia para um império emergente, e deve ser pesquisado o mais cedo possível.';
$LNG['info'][117]['name']        = 'Motor de Impulsão';
$LNG['info'][117]['description'] = 'Uma grande parte de matéria repulsada resulta em restos e lixo, criados pela fusão nuclear. Cada evolução desta tecnologia aumenta em 20% a velocidade das naves mais pesadas como o cruzador, bombardeiro, caça pesado e nave de colonização. Os motores de impulsão são um desenvolvimento adicional aos motores de combustão, aumentam a eficiência e abaixam o consumo de combustível relativo á velocidade.';
$LNG['info'][118]['name']        = 'Motor Propulsor de Hiperespaço';
$LNG['info'][118]['description'] = 'O motor propulsor é baseado na curvatura do espaço-tempo. Desta maneira, o ambiente das naves que utilizam este motor propulsor comprime-se, permitindo que as naves percorram grandes distãncias em muito pouco tempo. A evolução do motor propulsor aumenta a velocidade de algumas naves em 30%. Requesitos: Tecnologia de Hiperespaço (Nível 3) Laboratório de Pesquisa (Nível 7).';
$LNG['info'][120]['name']        = 'Tecnologia Laser';
$LNG['info'][120]['description'] = 'O laser (amplificação de luz pela emissão estimulada da radiação) cria um raio intenso de luz, que concentra uma grande quantidade de energia. O laser tem várias áreas de aplicação como os sistemas ópticos de computadores, e as armas com alto poder destructivo. O conhecimento desta tecnologia é fundamental para a investigação de novas armas.<br/>Requisitos: Laboratório de Pesquisas (Nível 1) Tecnologia de Energia (Nível 2).';
$LNG['info'][121]['name']        = 'Tecnologia de Iôes';
$LNG['info'][121]['description'] = 'Ao acelerar iôes um raio letal é criado, e causa danos importantes aos objectos que atinge.';
$LNG['info'][122]['name']        = 'Tecnologia de Plasma';
$LNG['info'][122]['description'] = 'Tecnologia mais avançada que a tecnologia de iôes, em vez de acelerar iôes, acelera-se o plasma com um grande poder energético, desta forma cria-se um raio que ocasiona danos enormes aos objectos que atinge.';
$LNG['info'][123]['name']        = 'Rede Intergaláctica de Pesquisas';
$LNG['info'][123]['description'] = 'Os cientistas dos teus planetas podem comunicar uns com os outros graças a esta rede.<br/>No nível 0, terás apenas o benefício de ligar o satélite ao teu laboratório de pesquisas mais evoluído. Com o nível 1, ligarás os 2 laboratórios mais evoluídos. Cada nível acrescenta mais um laboratório. Desta maneira, as pesquisas serão efectuadas com a máxima velocidade.';
$LNG['info'][124]['name']        = 'Tecnologia de Exploração Espacial';
$LNG['info'][124]['description'] = 'A tecnologia de Exploração Espacial inclui formas de pesquisa á distância e permite o uso de módulos de pesquisa nas naves, estes últimos são compostos por uma base de dados funcional num laboratório móvel. Para assegurar a segurança destas naves durante situações de pesquisa extremas, o módulo contêm o seu próprio sistema de energia que cria um poderoso campo de forças á volta do módulo durante uma emergência.';
$LNG['info'][131]['name']        = 'Maximização da produção de Metal';
$LNG['info'][131]['description'] = 'Aumentar a procução da mina de metal por 2%';
$LNG['info'][132]['name']        = 'Maximização da produção de Cristal';
$LNG['info'][132]['description'] = 'Aumentar a produção da mina de cristal por 2%';
$LNG['info'][133]['name']        = 'Maximização da produção de Deutério';
$LNG['info'][133]['description'] = 'Aumentar a produção do sintetizador de deuterio por 2%';
$LNG['info'][199]['name']        = 'Tecnologia de Gravitação';
$LNG['info'][199]['description'] = 'Um gráviton é uma partícula elementar responsável pelos efeitos da gravitação. Com o aceleramento de partículas gravitacionais, um campo gravitacional artificial é criado com uma força atractiva que pode não só destruir naves mas também luas inteiras. De maneira a produzir a quantidade necessária de partículas de gravitação, o planeta tem que poder criar uma quantidade maciça de energia. Requisitos: Laboratório de Pesquisas (Nível 12).';

// ----------------------------------------------------------------------------------------------------------
// Schiff'
$LNG['info'][202]['name']        = 'Cargueiro Pequeno';
$LNG['info'][202]['description'] = 'Estas naves são aproximadamente do tamanho de uma nave de combate, mas não são equipadas nem com motores nem com armamento de combate, para deixar mais espaço para os recursos a transportar. O cargueiro pequeno pode transportar até 5.000 unidades de recursos.<br/>A velocidade básica dos teus cargueiros pequenos é aumentada logo que a tecnologia de impulsão nível 5 for pesquisada, já que ficam equipados com motores de impulsão.';
$LNG['info'][203]['name']        = 'Cargueiro Grande';
$LNG['info'][203]['description'] = 'Esta nave não deve atacar sozinha, pois a sua estrutura não lhe permite resistrir muito tempo aos sistemas de defesa. O seu motor de combustão altamente sofisticado permite-lhe ser um fornecedor rápido do recursos. Normalmente, acompanha as frotas em invasões a planetas para capturar e roubar recursos ao inimigo.';
$LNG['info'][204]['name']        = 'Caça Ligeiro';
$LNG['info'][204]['description'] = 'Considerando a sua estrutura, agilidade e alta velocidade, o caça ligeiro pode ser definido como uma boa arma no principio do jogo, e um bom acompanhante para as naves mais sofisticadas e poderosas.';
$LNG['info'][205]['name']        = 'Caça Pesado';
$LNG['info'][205]['description'] = 'Durante a evolução do caça ligeiro os investigadores chegaram ao ponto onde a tecnologia convencional alcança os seus limites. De maneira a fornecer agilidade ao novo caça, um poderoso motor de impulsão foi usado pela primeira vez. Apesar dos custos e da complexidade adicionais, novas possibilidades tornaram-se disponíveis. Com o uso da tecnologia de impulsão e a integridade estrutural aumentada, foi possível dar ao caça pesado um sistema de armas e uma resistência necessitando mais energia transformando a nave numa verdadeira ameaça para o inimigo.';
$LNG['info'][206]['name']        = 'Cruzador';
$LNG['info'][206]['description'] = 'Com os lasers pesados e os canhões do iões que emergem nos campos de batalha, as naves básicas de combate encontravam cada vez mais em dificuldade. Apesar de muitas modificações nos sistemas de arma estas naves não podiam ser aumentadas ou evoluidas bastante para poder rivalizar com os novos sistemas de defesa.<br/>Por esta razão, foi decidido desenvolver uma nova nave, poderosa e com sistemas de armas devastadores. Nasceu então o cruzador.<br/>Os cruzadores possuem um sistema de armas três vezes mais poderoso do que aquele encontrado no caça pesado e uma velocidade de tiro aumentada. A velocidade do cruzador é a mais rápida já vista. Infelizmente, com o aparecimento mais tarde dos novos e mais fortes sistemas de defesa como os canhões de Gauss e os lançadores de plasma, o domínio dos cruzadores acabou. O cruzador tem RapidFire(10) contra os lançadores de mísseis e contra os caças ligeiros, isso quer dizer que um cruzador destrói sempre mais de um míssil ou caça ligeiro a cada round.';
$LNG['info'][207]['name']        = 'Nave de Batalha';
$LNG['info'][207]['description'] = 'As naves de batalha constituem a espinha dorsal de qualquer frota militar. Os sistemas de armas poderosos e a resistência inigualável da nave de batalha adicionados à alta velocidade e à capacidade de carga importante fazem desta nave um perigo constante, em qualquer situação e contra qualquer oponente.';
$LNG['info'][208]['name']        = 'Nave de Colonização';
$LNG['info'][208]['description'] = 'Esta nave permite colonizar novos planetas, outros mundos, onde nenhum homem ainda se aventurou no passado. Um império pode possuir até 8 colónias. As naves de colonização têm dupla utilização. Podem servir como cargueiros (não recomendado pela sua lentidão), e como naves de colonização. Se pretendes colonizar um planeta, não envies recursos com a nave de colonização, pois estes serão perdidos.';
$LNG['info'][209]['name']        = 'Reciclador';
$LNG['info'][209]['description'] = 'Os combates no espaço parecem tornar-se cada vez mais impressionantes onde numa única batalha milhares de naves podem ser destruídas, e os restos perdidos para sempre. Os cargueiros não têm os meios para recolher esses recursos valiosos.<br/>Com o desenvolvimento das naves espaciais, veio a ser possível recolher aqueles campos de ruínas. Um reciclador é do tamanho de um cargueiro grande e tem uma capacidade de armazenamento limitada de 20.000 unidades.';
$LNG['info'][210]['name']        = 'Sonda de Espionagem';
$LNG['info'][210]['description'] = 'As sondas de espionagem são drones com uma rapidez impressionante de propulsão utilizados para espiar os inimigos. Com um sistema de comunicação altamente avançado as sondas podem emitir dados a grande distância.<br/>Quando chegam ao planeta alvo, as sondas permanecem na orbita de maneira a recolher os dados do planeta. Durante esse período é relativamente fácil detectá-las. Uma vez detectadas, devido à fraqueza da sua estrutura, as sondas não podem resistir muito tempo aos tiros dos sistemas de defesa, e são rapidamente destruidas.<br/>Para que o tempo de permanencia em órbita seja o mais reduzido possível, é conveniente ter uma Tecnologia de Espionagem bem desenvolvida.';
$LNG['info'][211]['name']        = 'Bombardeiro';
$LNG['info'][211]['description'] = 'O bombardeiro é uma nave espacial desenvolvida para destruir os sistemas de defesa planetários mais recentes e poderosos. Dotado de um sistema de escolha de alvo guiado ao laser, e de bombas de plasma, o bombardeiro é uma arma destrutiva.<br/>A velocidade básica dos teus bombardeiros é aumentada assim que seja pesquisado o motor de hiperespaço nível 8, já que ficam equipadas com o motor de hiperespaço.';
$LNG['info'][212]['name']        = 'Satélite Solar';
$LNG['info'][212]['description'] = 'Os satélites solares são satélites simples situados na órbita de um planeta, equipados de células fotovoltaicas, capazes de transferir energia para o planeta. A energia é transmitida ao planeta graças a um feixe de laser especial.<br/>Estes satélites são uma ajuda ao nível da procura de energia, mas não resistem aos tiros das naves inimigas, e desta maneira a perda de os satélites pode ser fatal para a sobrevivência energética do teu planeta.';
$LNG['info'][213]['name']        = 'Destruidor';
$LNG['info'][213]['description'] = 'Com o destruidor, a mãe de todas as naves entra na arena. O sistema de armas desta nave é constituído por canhões de ion-plasma e canhões de Gauss, adicionando um sistema de detecção e escolha de alvo, a nave pode destruir caças ligeiros voando em plena velocidade com 99% de probabilidade. A agilidade deste monstro de guerra é evidentemente embora a velocidade seja um grande ponto negativo, mas o destruidor pode ser considerado mais como uma estação de combate do que uma nave, com uma capacidade de transporte importante, acompanha as naves de batalha e dá uma ajudinha decisiva.';
$LNG['info'][214]['name']        = 'Estrela da Morte';
$LNG['info'][214]['description'] = 'Uma embarcação deste tamanho e deste poder necessita uma quantidade gigantesca de recursos e mão de obra que podem ser fornecidos somente pelos impérios mais importantes de todo o universo.';
$LNG['info'][215]['name']        = 'Interceptor';
$LNG['info'][215]['description'] = 'Esta nave, uma filigrana tecnológica, é mortal na altura de destruir frotas inimigas. Com os seus canhões de laser aperfeiçoados, mantém uma posição privilegiada entre as naves pesadas, onde pode destruir bastantes em menos de nada. Devido ao seu pequeno design e ao seu enorme poderio de armas, a capacidade de carga é mínima, mas isto é compensado com um consumo baixo de combustível do motor de hiperespaço embutido.';
$LNG['info'][216]['name']        = 'Estrela Destruidora';
$LNG['info'][216]['description'] = 'O sucessor das populares estrelas da morte, um pouco mais rápido e mais forte, devido ao seu melhor armamento e motores mais potentes torna está nave um perigo para as luas.';
$LNG['info'][217]['name']        = 'Evo. Transportador';
$LNG['info'][217]['description'] = 'Este é o sussecor do cargeiro Grande o Evo. Transportador, com uma capacidade de carga muito acima do normal, e mais rápida que o seu anterior, faz desta nave um supremo monstro de carga.';
$LNG['info'][218]['name']        = 'Avatar';
$LNG['info'][218]['description'] = 'Esta pode ser chamada a nave de destruição mas nem tudo são vantagens, o seu tamanho faz desta nave um monstro lento. Mas muito usada para limpar planetas com bunckers.';
$LNG['info'][219]['name']        = 'Giga. Reciclador';
$LNG['info'][219]['description'] = 'O Giga.Reciclador é uma nave muito desejáda devido há sua capacidade de carga e velocídade, mas continua sem sistemas de defesa o que faz dela uma nave impotente a não ser para reciclagem.';
$LNG['info'][220]['name']        = 'Sondador de MN';
$LNG['info'][220]['description'] = 'Após longos anos de pesquisas, foi possivel criar a nave que sonda matéria negra, somente apartir da lua.';


// ----------------------------------------------------------------------------------------------------------
// Verteidigung
$LNG['info'][401]['name']        = 'Lançador de Mísseis';
$LNG['info'][401]['description'] = 'O lançador de mísseis é um sistema de defesa simples e barato. Tornam-se muito eficazes em número e podem ser construídos sem pesquisa específica porque é uma arma de balística simples. Os custos de fabricação baixos fazem desta arma defensiva um adversário apropriado para frotas pequenas.<br/>Em geral, os sistemas de defesa desactivam-se ao alcançar parâmetros operacionais críticos de maneira a fornecer uma possibilidade de reparação. 70% da defesa planetária destruída pode ser reparada depois dum combate.';
$LNG['info'][402]['name']        = 'Laser Ligeiro';
$LNG['info'][402]['description'] = 'Para acompanhar o ritmo com a velocidade sempre crescente do desenvolvimento das tecnologias de naves espaciais, os cientistas tiveram que criar um tipo novo de sistema da defesa capaz de destruír as naves mais fortes.<br/>Rapidamente, o laser ligeiro foi inventado, este pode disparar um feixe de laser altamente concentrado no alvo e criar danos muito mais elevados do que o impacto de mísseis balísticos. Um preço baixo da unidade era um objetivo essencial do projeto, por isso a estrutura basica não foi melhorada comparada ao lançador de mísseis.';
$LNG['info'][403]['name']        = 'Laser Pesado';
$LNG['info'][403]['description'] = 'O laser pesado é uma evolução directa do laser ligeiro, a integridade estrutural foi evoluída e aumentada e materiais novos foram adoptados. Com os novos sistemas de energia e novos computadores, muito mais energia pode ser utilizada e dirigida para disparar fogo sobre o inimigo.';
$LNG['info'][404]['name']        = 'Canhão de Gauss';
$LNG['info'][404]['description'] = 'Durante muito tempo pensou-se que as armas de projécteis iam ser como a tecnologia de fusão e de energia, o desenvolvimento da propulsão de hiperespaço e o desenvolvimento de protecções melhoradas ficando antigas até que a tecnologia de energia, que a tinha posta de lado naquele tempo, as fez renascer. O princípio já era conhecido no século XX - o princípio de aceleração de partículas. Um canhão de gauss (canhão eletromagnético) não é nada mais que um acelerador de partículas, onde os projécteis com um peso de várias toneladas começam a ser acelerados. Mesmo as protecções modernas, a blindagem ou os escudos têm dificuldades em resistir a esta força, acabando um projéctil por atravessar completamente o objecto. Os sistemas de defesa desactivam-se quando estão demasiado estragados. Depois de uma batalha, 70% dos sistemas danificados podem ser reparados.';
$LNG['info'][405]['name']        = 'Canhão de Iões';
$LNG['info'][405]['description'] = 'No século XXI existiu algo com o nome de PEM. O PEM era um pulso eletromagnético que causava uma tensão adicional em cada circuito, o que provocava muitos incidentes de obstrução nos instrumentos mais sensíveis. O PEM foi baseado em mísseis e bombas, e também em relação às bombas atómicas. O PEM foi depois evoluído para fazer objectos incapazes de agir sem serem destruidos. Hoje, o canhão de iões é a versão mais moderna do PEM que lança uma onda de iões contra um objecto (naves), destabilizando-lhe desta maneira as protecções e a electrónica. A força cinética não é significativa. Os cruzadores também utilizam esta tecnologia. é interessante não destruir uma embarcação mas paralizá-la. Depois de uma batalha 70% dos sistemas danificados podem ser reparados.';
$LNG['info'][406]['name']        = 'Canhão de Plasma';
$LNG['info'][406]['description'] = 'A tecnologia de laser foi melhorada, a tecnologia de iões alcançou a sua fase final. Pensou-se que seria impossível criar sistemas de armas mais eficazes. A possibilidade de combinar os dois sistemas mudou este pensamento. Sabia-se já que a tecnologia de fusão, das partículas dos lasers (geralmente deutério) faz aumentar a temperatura até milhões de graus. A tecnologia de iões permite o carregamento elétrico das partículas, a ligação em redes de estabilidade e a aceleração das partículas. Assim nasce o plasma. A esfera de plasma é azul e visualmente atractiva, mas é difícil pensar que um grupo de embarcações fique muito feliz de a ver. O canhão de plasma é uma das armas mais poderosas, embora seja uma tecnologia é muito cara. Depois de uma batalha, 70% dos sistemas danificados podem ser reparados.';
$LNG['info'][407]['name']        = 'Pequeno Escudo Planetário';
$LNG['info'][407]['description'] = 'Muito tempo antes da instalação dos escudos em embarcações, os geradores já existiam na superfície dos planetas. Cobriam os planetas e eram capazes de absorver quantidades enormes de danos antes de serem destruídos. Os ataques com frotas ligeiras falhavam frequentemente quando se encontravam com estes geradores. Mais tarde, foi imaginado a criação de um enorme escudo planetário. Para cada planeta um escudo planetário.';
$LNG['info'][408]['name']        = 'Grande Escudo Planetário';
$LNG['info'][408]['description'] = 'O grande escudo planetário cobre o planeta para absorver quantidades enormes de tiros. A sua resistência é muito maior daquela encontrada no pequeno escudo planetário e francamente resistente contra o RapidFire das naves de combate.';
$LNG['info'][409]['name']        = 'Giant Shield Dome';
$LNG['info'][409]['description'] = 'The further development of the Large Shield Dome. It is based on the same technologies can also use considerably more energy to deter enemy attacks.';
$LNG['info'][410]['name']        = 'Canhão de Gravitação';
$LNG['info'][410]['description'] = 'Após anos de pesquisa sobre a força gravitacional os pesquisadores desenvolveram um Canhão de Gravitação que produs pequenos Gravitões concentrados e podem ser disparados contra o inimigo. Esta foi uma das descobertas feitas logo de seguida depois das Estrelas da Morte, os cientístas já andavam desesperados devido a não haver sistemas de defesa capazes de destruir EDMs, então criaram este canhão mortal.';
$LNG['info'][411]['name']        = 'Sistema Orbitál de Defesa';
$LNG['info'][411]['description'] = 'Esta plataforma de proporções gigantescas, as maiores, que foram alguma vez vistas no universo. É uma plataforma imovél defensiva. Não tem acionamento direto e é realizada por Graviton tem uma órbita estável no planeta. O início deste processo exige massas elevadas de energia. Os pesquisadores estão a trabalhar em maneiras de construir naves nesta plataforma, a fim de usá-las como um anel externo de defesa, permitindo que o adversário mais difícil do planeta não tenha ipoteses de entrar nas nossas defesas. Devido à dimensão enorme, só é possível ter um desses monstros.';
// ----------------------------------------------------------------------------------------------------------
// Raketen
$LNG['info'][502]['name']        = 'Míssil de Intercepção';
$LNG['info'][502]['description'] = 'O míssil de intercepção destrói os mísseis interplanetários atacantes. Cada míssil de intercepção pode destruir um míssil interplanetário lançado em ataque.';
$LNG['info'][503]['name']        = 'Míssil Interplanetário';
$LNG['info'][503]['description'] = 'O míssil interplanetário destrói os sistemas de defesa do inimigo. Os sistemas destruidos desta maneira não podem ser reparados.';

// ----------------------------------------------------------------------------------------------------------
// oficiais
$LNG['info'][601]['name']        = 'Geólogo';
$LNG['info'][601]['description'] = '<br><br>O Geólogo é um experiente astromineralogista e cristalografista. Ele assiste as suas equipas de metalurgia e química assim como cuida das comunicações interplanetárias optimizando o seu uso e na refinação das matérias-primas por todo o império.<br><br><font color="red">+%s%% na produção de recursos. Nivel max: %s</font>';
$LNG['info'][602]['name']        = 'Almirante';
$LNG['info'][602]['description'] = '<br><br>O Almirante de frota é um experiente veterano de Guerra e estratega também.. Nos combates mais difíceis, ele é capaz de definir uma estratégia e transmiti-la aos seus subordinados. Um sábio imperador pode confiar no seu suporte em batalhas.<br><br><font color="red">+%s%% em escudos. Nivel max: %s</font>';
$LNG['info'][603]['name']        = 'Engenheiro';
$LNG['info'][603]['description'] = '<br><br>O engenheiro é especialista na gestão de energia. Em épocas de paz, aumenta a energia de todas as tuas colónias. Em caso de ataque, assegura a fonte de energia aos canhões defensivos, evitando uma eventual sobrecarga, reduzindo deste modo as perdas na batalha.<br><br><font color="red">+%s%% de Energia . Nivel max: %s</font>';
$LNG['info'][604]['name']        = 'Tecnocrata';
$LNG['info'][604]['description'] = '<br><br>A Ordem dos cientistas é composta por grandes génios. Podes encontrá-los sempre a discutir questôes que desafiariam a lógica de qualquer pessoa. Nenhuma pessoa normal conseguirá descobrir o código desta ordem, e é a sua presença que inspira todos investigadores no Império a conseguir mais e melhor.<br><br><font color="red">-%s%% do tempo de construção de naves. Nivel max: %s</font>';
$LNG['info'][605]['name']        = 'Construtor';
$LNG['info'][605]['description'] = '<br><br>O construtor tem o seu DNA alterado, apenas um destes homens seria capaz de construir uma cidade num curto periodo de tempo. <br><br><font color="red">-%s%% do tempo de construção. Nivel max: %s</font>';
$LNG['info'][606]['name']    	 = 'Cientista';
$LNG['info'][606]['description'] = '<br><br>Os cientistas sao uma especie de clã concorrente aos tecnocratas. Especializam-se na evolução da tecnologia.<br><br><font color="red">-%s%% do tempo do pesquisa. Nivel Maximo: %s</font>';
$LNG['info'][607]['name']    	 = 'Especialista de Armazenamento';
$LNG['info'][607]['description'] = '<br><br>O armazenamento faz parte da irmandade do planeta Hsac. O seu lema era ganhar o maximo, o que implica aumentar a capacidade de armazenamento. Desde então a tecnica de armazenamento tem evoluido.<br><br><font color="red">+%s%% da capacidade de armazenamento. Nivel Maximo: %s</font>';
$LNG['info'][608]['name']    	 = 'Ministro da Defesa';
$LNG['info'][608]['description'] = '<br><br>O ministro da defesa e um membro exercito imperial. Concentrado no seu trabalho é capaz de construir uma defesa formidável num curto periodo de tempo.<br><br><font color="red">-%s%% no tempo de construção de defesas. Nivel max: %s</font>';
$LNG['info'][609]['name']    	 = 'Guardião';
$LNG['info'][609]['description'] = '<br><br>O guardião é um membro do exército imperial e tem como objectivo fazer evoluir as defesas de um planeta.<br><br><font color="red">Desbloqueia o Grande Escudo Planetário. Nivel max: %s</font>';
$LNG['info'][610]['name']    	 = 'Espião';
$LNG['info'][610]['description'] = '<br><br>O espião é uma personagem enigmática. Nunca ninguem viu a sua verdadeira face, a unica maneira de isso acontecer seria sendo morto.<br><br><font color="red">+%s Niveis de Espionagem. Nivel max: %s</font>';
$LNG['info'][611]['name']    	 = 'Comandante';
$LNG['info'][611]['description'] = '<br><br>O comandante faz parte do exército imperial e especializou-se na arte de coordenar as frotas. O seu cérebro e capaz de calcular um grande número de trajectorias.<br><br><font color="red">+%s espaços de frota. Nivel max: %s</font>';
$LNG['info'][612]['name']    	 = 'Destruidor';
$LNG['info'][612]['description'] = '<br><br>O destruidor é também um membro do exército imperial mas sem piedade. Desfaz tudo que se mete no seu caminho apenas por diversão. Está neste momento a desenvolver um novo metodo de produção da Estrela da Morte.<br><br><font color="red">Duas estrelas da morte por uma. Nivel max: %s</font>';
$LNG['info'][613]['name']    	 = 'General';
$LNG['info'][613]['description'] = '<br><br>O general é uma personagem que serviu durante muitos anos o exército imperial. Os trabalhadores tem uma produção de naves mais rápida na sua presença. <br><br><font color="red">+%s%% na velocidade de produção de naves. Nivel max: %s</font>';
$LNG['info'][614]['name']    	 = 'Conquistador';
$LNG['info'][614]['description'] = '<br><br>Esta personagem possui qualidades de conquista inigualáveis. Este sugere que tu te tornes um Raider. O Raider e o nivel mais alto da guarda imperial Raider.<br><br><font color="red">Nivel max: %s</font>';
$LNG['info'][615]['name']    	 = 'Imperador';
$LNG['info'][615]['description'] = '<br><br>Quando colocados sob o comando do imperador todos os oficiais do império, combinando suas habilidades para dominar o universo são capazes de se tornar num adversário quase invisívelO imperador colocado sob o seu comando disponíveis para todos os oficiais do império, combinando suas habilidades para dominar o universo e tornar-se um adversário quase invisíveis.<br><br><font color="red">Nivel max: %s</font>';

?>