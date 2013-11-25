<?php
/**
 * Curso loader
 *
 * @author Joe Robles <joe.robles.pdj@gmail.com>
 */
namespace Main\Services;

class Curso
{
    public $nombre;
    
    public function __construct($nombre) {
        $this->nombre = $nombre;
    }
    
    public function info()
    {
        $cursos =
            array(
                "coaching" => array(
                    "title" => "COACHING",
                    "contents" => array(
                        array("content" => "Coaching de vida y coaching para mejorar en la organización, orden y aprendizaje.")
                    ),
                    "staff" => array(
                        array("name" => "Yvonne Gómez-Restrepo:"),
                        array(
                            "teacher" => array(
                                array("experience" => "Terapeuta Integral y Complementaria."),
                                array("experience" => "Entrenadora y terapeuta Brain Gym-Edu-K - USA (Gimnasia Mental-Kinesiología Educativa) con especialidad en niños y adolescentes."),
                                array("experience" => "Terapeuta TREC (Terapia Racional Emotiva Conductual) Psicotrec-Perú- Catrec Argentina- Albert Ellis Institute - New York, con especialidad en niños, adolescentes y pacientes con desordenes alimenticios."),
                                array("experience" => "Maestra de Reiki, Yoga y Meditación (Estudios en Perú, Colombia, Chile y Argentina) maestra de la Escuela Peruana de Reiki, miembro de la Asociación Latinoamericana de Yoga y del Centro Internacional de Osho."),
                                array("experience" => "Autora del programa: Manual para padres Impacientes. Y Co-autora de Cartas Terapéuticas para niños."),
                                array("experience" => "Con 15 años de experiencia como terapeuta integral, atendiendo niños con problemas de salud, hiperactividad, angustia, ansiedad, problemas de conducta, etc.")
                            )
                        )
                    )
                ),
                "impro" => array(
                    "title" => "IMPRO",
                    "contents" => array(
                        array("content" => "La Improvisación Teatral es un deporte teatral en donde se busca crear historias y construir personajes en ese mismo momento y sin preparación alguna. Por medio de herramientas como la escucha y la aceptación todos los interesados pondrán a prueba todo su potencial usando su cuerpo y voz junto con el arma mas importante que contamos, la creatividad.")
                    ),
                    "staff" => array(
                        array("name" => "Jorge Germán Loero Marín:"),
                        array(
                            "teacher" => array(
                                array("experience" => "Más conocido como Germán Loero (nacido en Lima, Perú el 27 de octubre de 1979) es un joven actor de gran popularidad conocido por sus interpretaciones en exitosas series peruanas como 1000 Oficios, Así es la Vida, Las Locas Aventuras de Jerry y Marce, El Santo Convento, América Kids, La AKdemia entre otros."),
                                array("experience" => "Germán formó parte del elenco de Pataclaun, con ellos trabajó 3 años tanto en TV como en teatro, siendo su último proyecto la Telenovela Claun La Santa Sazón emitida de lunes a viernes por Panamericana Televisión. Hoy por hoy Germán se encuentra abocado a la docencia en sus talleres de Improvisación Teatral desde hace 2 años, los cuales son dictados en el Museo de Arte de Lima (MALI) y en la Escuela de Artes Escénicas Espacio Alterno de Ricky Tosso en Miraflores.")
                            )
                        )
                    )
                ),
                "pilates" => array(
                    "title" => "PILATES",
                    "contents" => array(
                        array("content" => "Pilates hace que la mente, el cuerpo y el espíritu trabajen como uno. Mediante la respiración y la concentración se logra un estado de relajación. De nuestro centro o Powerhouse es de donde parte toda la fuerza para realizar los movimientos corporales."),
                        array("content" => "Pilates exige a uno mismo un gran control corporal, mucha precisión y corrección de la postura a demás una gran consciencia de nuestro cuerpo."),
                        array("content" => "La concentración, siendo la mente la que guía todo el movimiento, y la correcta respiración que nos ayuda a llevarlo a cabo.")
                    ),
                    "staff" => array(
                        array("name" => "María del Carmen Aicardi:"),
                        array(
                            "teacher" => array(
                                array("experience" => "Con más de 10 años de experiencia en este arte, su taller va dirigido a adultos y adultos mayores.")
                            )
                        )
                    )
                ),
                "yoga-adultos" => array(
                    "title" => "YOGA",
                    "contents" => array(
                        array("content" => "Yoga no es solo movimiento corporal sino una manera de ver la vida y proceder las actividades cotidianas con otra actitud. Es unión de mente, cuerpo y espíritu y ayuda a recuperar unidad esencial que implica la armonía en si."),
                        array("content" => "* Tenemos un horario de yoga en Ingles.")
                    ),
                    "staff" => array(
                        array("name" => "Susana Husarová:"),
                        array(
                            "teacher" => array(
                                array("experience" => "Instructora de Yoga formada por Escuela de Yoga en la Republica Checa, cuenta con trayectoria por los países europeos, los Estados Unidos y actualmente en Latinoamérica. Su formación se desarrolla también en el campo de las artes, las danzas folclóricas y el estudio del piano clásico.")
                            )
                        )
                    )
                ),
                "terapiyo" => array(
                    "contents" => array(
                        array("content" => "El curso El Terapiyo es una secuencia que combina 4 artes :")
                    ),
                    "courses" => array(
                        array(
                            "course" => array(
                                array("course-title" => "1.- BRAIN GYM"),
                                array(
                                    "course-detail" => array(
                                        array("course-content" => "Es un método práctico y dinámico que favorece el óptimo funcionamiento de los dos hemisferios y mejora la conexión entre cerebro y cuerpo a través del movimiento."),
                                        array("course-content" => "Es un sistema de aprendizaje y enseñanza integral desarrollado para alcanzar la excelencia en el aprendizaje, la comunicación e integración mente-cuerpo y el óptimo rendimiento intelectual."),
                                        array("course-content" => "Ayuda a niños y adultos en:"),
                                        array("course-content" => "- dislexia"),
                                        array("course-content" => "- hiperactividad"),
                                        array("course-content" => "- síndrome de déficit atencional"),
                                        array("course-content" => "- discalculia, por mencionar los más usuales.")
                                    )
                                )
                            )
                        ),
                        array(
                            "course" => array(
                                array("course-title" => "2.- TEATRO"),
                                array(
                                    "course-detail" => array(
                                        array("course-content" => "En el teatro se juega a crear, inventar y aprender a participar en grupo. Las clases de teatro infantil son terapéuticas y socializadoras. Los trabajos en grupo, los ejercicios psicomotores y el contacto físico entre los compañeros, hace que nuestros niños se tornen mas tolerantes y receptivos. El teatro infantil no se trata de promocionar y crear actores, sino que debe ser visto como una experiencia que se adquiere a través del juego."),
                                        array("course-content" => "Además que nos ayuda a desarrollar la expresión verbal y corporal, y a estimular la capacidad de memoria y la agilidad mental."),
                                        array("course-content" => "En el teatro el niño aumenta su autoestima, aprenden a respetar y convivir en grupo, conocen y controlan sus emociones, descubren lo que es la disciplina y la constancia en el trabajo, además de desenvolverse entre el público, estimulando la creatividad e imaginación haciéndolos sentir mas seguros de si mismos.Para hacer teatro no es necesario ser un artista, bastará con querer divertirse, inventar e interpretar historias, y hacer amigos.")
                                    )
                                )
                            )
                        ),
                        array(
                            "course" => array(
                                array("course-title" => "3.- YOGA"),
                                array(
                                    "course-detail" => array(
                                        array("course-content" => "El practicar yoga es muy beneficioso tanto para el cuerpo como para la mente."),
                                        array("course-content" => "La práctica del Yoga enseña a tanto niños como adultos técnicas de respiración y relajación para hacer frente a las situaciones de tensión que se presentan en la escuela, en casa o con amigos promoviendo en todo momento la salud física, mental y una actitud positiva hacia el ejercicio."),
                                        array("course-content" => "Los niños que practican Yoga se convierten en personas seguras, sociables y con un excelente nivel de autoestima."),
                                        array("course-content" => "El yoga nos ayuda a relajarnos y a conocernos a nosotros mismos, nos ayuda a canalizar nuestra energía, sobre todo a niños muy inquietos, nos ayuda también a enfrentar canalizando nuestros miedos y ansiedades a demás de mejorar nuestro estado de animo"),
                                        array("course-content" => "El yoga mejora las conductas agresivas en los chicos por lo que resulta una muy buena práctica para mejorar el desempeño social."),
                                        array("course-content" => "Los ayuda a concentrarse lo que puede ser muy beneficioso para su proceso de aprendizaje."),
                                        array("course-content" => "Desde el punto de vista corporal, les da flexibilidad y elasticidad, los ayuda a desarrollar destrezas motoras y a estimular y activar distintos músculos, articulaciones, glándulas y órganos."),
                                        array("course-content" => "Las clases de yoga para niños incorporan la diversión y la creatividad en sus ejercicios. La flexibilidad y el conocimiento y descubrimiento de uno mismo. Los ejercicios de yoga para niños también incluyen concentración, relajación y técnicas de autocontrol. Estos promueven la fortaleza espiritual, la confianza y el respeto por uno mismo.")
                                    )
                                )
                            )
                        ),
                        array(
                            "course" => array(
                                array("course-title" => "4.- REIKI"),
                                array(
                                    "course-detail" => array(
                                        array("course-content" => "Reiki es una palabra japonesa que significa energía vital."),
                                        array("course-content" => "Reiki, es un método de armonización y sanación natural, no religioso, y complementario, lo que significa que se suma al tratamiento médico tradicional, no lo reemplaza, lo complementa y potencia. Está basado en la canalización de la energía universal \"Rei\" (que nos rodea y es parte vital de todo lo que existe), y la energía vital personal \"Ki\", en síntesis, reiki es la suma de estas dos energías."),
                                        array("course-content" => "Reiki también ayuda a los niños que son muy tranquilos a ser más receptivos, puesto que esta energía agudiza los sentidos.")
                                    )
                                )
                            )
                        )
                    ),
                    "staffs" => array(
                        array(
                            "staff" => array(
                                array("name" => "Yvonne Gómez-Restrepo:"),
                                array(
                                    "teacher" => array(
                                        array("experience" => "Terapeuta Integral y Complementaria."),
                                        array("experience" => "Entrenadora y terapeuta Brain Gym-Edu-K - USA (Gimnasia Mental-Kinesiología Educativa) con especialidad en niños y adolescentes."),
                                        array("experience" => "Terapeuta TREC (Terapia Racional Emotiva Conductual) Psicotrec-Perú- Catrec Argentina- Albert Ellis Institute - New York, con especialidad en niños, adolescentes y pacientes con desordenes alimenticios."),
                                        array("experience" => "Maestra de Reiki, Yoga y Meditación (Estudios en Perú, Colombia, Chile y Argentina) maestra de la Escuela Peruana de Reiki, miembro de la Asociación Latinoamericana de Yoga y del Centro Internacional de Osho."),
                                        array("experience" => "Autora del programa: Manual para padres Impacientes. Y Co-autora de Cartas Terapéuticas para niños."),
                                        array("experience" => "Con 15 años de experiencia como terapeuta integral, atendiendo niños con problemas de salud, hiperactividad, angustia, ansiedad, problemas de conducta, etc.")
                                    )
                                )
                            )
                        ),
                        array(
                            "staff" => array(
                                array("name" => "Christine Brahm:"),
                                array(
                                    "teacher" => array(
                                        array("experience" => "Entrenadora y terapeuta Brain Gym-Edu-K - USA (Gimnasia Mental-Kinesiología Educativa) con especialidad en niños y adolescentes. Terapeuta Reiki (Escuela Peruana de Reiki).")
                                    )
                                )
                            )
                        ),
                        array(
                            "staff" => array(
                                array("name" => "Analía Cáceres:"),
                                array(
                                    "teacher" => array(
                                        array("experience" => "Entrenadora y terapeuta Brain Gym-Edu-K - USA (Gimnasia Mental-Kinesiología Educativa) con especialidad en niños y adolescentes. Terapeuta Reiki (Escuela Peruana de Reiki).")
                                    )
                                )
                            )
                        ),
                        array(
                            "staff" => array(
                                array("name" => "Joshue Pichilingue:"),
                                array(
                                    "teacher" => array(
                                        array("experience" => "Tiene formacion de bailarin, estudio en la escuela de Lucy Telge(directora del Ballet Municipal) y en el Ballet de la Universidad de San Marcos."),
                                        array("experience" => "Estudio Psicologia en la Uniersidad Peruana Unión (Perú) y continuo su formacion en la Universidad Nacional de Educacion a distancia (España), formacion en Lima yoga, Akro Estudio, Ki'ntu, formacion en la Universidad Internacional de la Rioja (España), y talleres de actualizacion y cuidado de la columna tanto en España, Italia y Portugal."),
                                        array("experience" => "Experiencia laboral en Scene (escuela de artes escenicas), Sport Life, World Gym, Casa del Adulto Mayor, Gimnasia Laboral en el Banco de la Nacion, y el Scotiabank, Cadena del Gol's Gym y en el Club Lima Golf")
                                    )
                                )
                            )
                        ),
                        array(
                            "staff" => array(
                                array("name" => "Titi Plaza:"),
                                array(
                                    "teacher" => array(
                                        array("experience" => "Estudio Derecho y ciencias políticas en la universidad nacional Federico Villareal."),
                                        array("experience" => "Taller de formación actoral con Osvaldo cattone, tiene más de 15 años de experiencia como actriz en el Perú y extranjero."),
                                        array("experience" => "Actualmente dicta clases de teatro a niños y adolescentes y cuenta con una productora teatral hace más de 10 años.")
                                    )
                                )
                            )
                        ),
                        array(
                            "staff" => array(
                                array("name" => "Gianni Chichizola:"),
                                array(
                                    "teacher" => array(
                                        array("experience" => "Estudio Ciencias de la Comunicación en la Universidad San Martín de Porres."),
                                        array("experience" => "Taller de formación actoral con Roberto Ángeles, Aristóteles Piccho, Fernando Petong y Joaquín Jordan."),
                                        array("experience" => "Tiene un programa en Radio Planeta 107.7: Universo Paralelo que tiene 6 años al aire."),
                                        array("experience" => "Es animador de eventos para empresas, Locutor comercial y actor. En la actualidad da clases de Expresión corporal y Teatro en el nido A Pasitos."),
                                        array("experience" => "Y está en la Obra Teatral El Proyecto Laramie")
                                    )
                                )
                            )
                        ),
                        array(
                            "staff" => array(
                                array("name" => "Flor de María Andrade:"),
                                array(
                                    "teacher" => array(
                                        array("experience" => "Cerca de 40 años de experiencia como actriz en Perú y en el extranjero."),
                                        array("experience" => "Se formó como actriz en las academias de Mario Rivera, Jorge Barrios Saavedra, entre otros."),
                                        array("experience" => "Llevo cursos de teatro en Estados Unidos."),
                                        array("experience" => "Contó con una academia de formación actoral por 10 años, enseño en diversos colegios y universidades."),
                                        array("experience" => "Profesora en la municipalidad de barranco de teatro enseñando a niños adolescentes y adultos.")
                                    )
                                )
                            )
                        )
                    )
                ),
            );
        
        return $cursos[$this->nombre];
    }
}
