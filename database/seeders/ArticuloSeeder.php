<?php

namespace Database\Seeders;

use App\Models\Articulo;
use Illuminate\Database\Seeder;

class ArticuloSeeder extends Seeder
{
    public function run(): void
    {
        $articulos = [
            [
                'categoria' => 'estres',
                'titulo' => 'Una pausa breve también cuenta',
                'resumen' => 'Ideas sencillas para bajar el ritmo entre trabajo, clases y tareas.',
                'contenido' => [
                    'Si llegas de trabajar y todavía tienes tareas, no necesitas resolverlas todas de una vez. Detente unos minutos, bebe agua y observa qué es lo más urgente y posible para hoy.',
                    'Prueba dividir la siguiente actividad en un paso pequeño, como leer una página o escribir tres ideas. Una pausa no reemplaza el descanso, pero puede ayudarte a volver con más claridad.',
                    'Si el estrés se mantiene y afecta tu vida diaria, hablar con alguien de confianza o buscar orientación profesional puede ayudarte.',
                ],
                'contexto' => [
                    'Salir del trabajo, trasladarte al instituto y pensar en una entrega pendiente puede hacer que incluso un descanso corto parezca imposible. El estrés es una respuesta ante exigencias, pero sostener ese estado durante muchos días puede dejarte sin espacio para recuperarte. No significa que estés fallando ni que debas poder con todo sin apoyo.',
                    'Una pausa breve sirve para reconocer cómo estás y elegir el siguiente paso. No resuelve por sí sola una carga de trabajo excesiva, problemas económicos o falta de tiempo. Por eso también importa revisar qué compromisos puedes negociar y qué tareas pueden esperar. Cuidarte incluye reconocer los límites reales de tu jornada.',
                ],
                'senales' => [
                    'Te cuesta concentrarte aun cuando intentas empezar por una tarea pequeña.',
                    'Notas tensión, irritabilidad o cansancio que no ceden al terminar la clase.',
                    'Dejas de comer, descansar o conversar por sentir que siempre falta tiempo.',
                ],
                'acciones' => [
                    'Haz una pausa con intención: aléjate de la pantalla, toma agua y observa si necesitas comida, movimiento o silencio antes de seguir.',
                    'Anota todo lo pendiente y separa lo urgente de lo que puede esperar. Elegir una sola prioridad para esta noche puede darte un punto de partida.',
                    'Si un plazo no es posible, conversa con el docente o con tu equipo antes de la fecha de entrega. Explica tu situación y propón un avance concreto.',
                    'Reserva algún momento de recuperación en tu semana, aunque sea breve. El descanso también forma parte de sostener el estudio y el trabajo.',
                ],
                'ayuda' => 'Si la sensación de estar sobrepasado continúa, interfiere con tus actividades o te cuesta descansar, cuéntaselo a alguien de confianza. Puedes decir: “Llevo varios días con mucha carga y necesito ordenar lo que me está pasando”. Pregunta en el instituto si hay orientación estudiantil o consulta en un servicio de salud. Si te sientes en peligro inmediato, busca atención de emergencia presencial en tu zona.',
            ],
            [
                'categoria' => 'estres',
                'titulo' => 'Antes de un examen: prepara lo que sí controlas',
                'resumen' => 'Un plan breve puede hacer más manejable la presión de una evaluación.',
                'contenido' => [
                    'La noche anterior, elige dos o tres temas prioritarios en vez de intentar repasar todo. Prepara tus materiales y revisa la hora y el lugar de la evaluación.',
                    'Durante el examen, lee las consignas con calma. Si una pregunta te bloquea, pasa a otra y vuelve después si hay tiempo. Una respuesta difícil no define tu valor como estudiante.',
                    'Si la preocupación por los exámenes te impide dormir o realizar tus actividades con frecuencia, considera pedir apoyo.',
                ],
                'contexto' => [
                    'Después de un día de trabajo, una prueba nocturna puede sentirse como otra exigencia para la que nunca hay tiempo suficiente. La preocupación antes de evaluar lo aprendido es comprensible. Puede volverse difícil de manejar cuando ocupa toda la noche, interrumpe el descanso o hace que evites presentarte, aunque te hayas preparado.',
                    'A veces el temor no viene solo del contenido: también pesan la posibilidad de atrasarte, el dinero invertido, la opinión de otras personas o una experiencia anterior. Ninguna de esas presiones define tu capacidad. Prepararte ayuda, pero no necesitas eliminar por completo los nervios para participar en una evaluación o una presentación.',
                ],
                'senales' => [
                    'Repasas sin poder detenerte, pero sientes que nada es suficiente.',
                    'Evitas practicar o asistir por miedo a equivocarte frente a otros.',
                    'La preocupación afecta repetidamente tu sueño, tu alimentación o tu concentración.',
                ],
                'acciones' => [
                    'Divide el repaso en temas esenciales y comprueba lo que recuerdas con ejercicios breves. Deja para otro momento los detalles menos importantes.',
                    'Ensaya una explicación corta en voz alta si tienes una exposición. Practicar con una persona de confianza puede hacer más familiar el momento.',
                    'Antes de comenzar, apoya los pies en el suelo y dedica unos instantes a respirar con calma. Luego lee una consigna a la vez.',
                    'Si aparece un bloqueo, marca la pregunta y continúa con otra. Volver después es una estrategia de trabajo, no una señal de incapacidad.',
                ],
                'ayuda' => 'Si este malestar se repite, te lleva a faltar a evaluaciones o afecta otras partes de tu vida, habla con un docente, tutor o persona de confianza. Puedes pedir que te expliquen criterios y fechas, y consultar si el instituto cuenta con orientación. Un profesional de salud puede ayudarte a comprender lo que te ocurre y a encontrar recursos adecuados.',
            ],
            [
                'categoria' => 'sueno',
                'titulo' => 'Cuidar el sueño cuando estudias de noche',
                'resumen' => 'Pequeños ajustes para proteger el descanso después de una jornada larga.',
                'contenido' => [
                    'Si trabajas y estudias de noche, intenta reservar una hora de cierre para dejar tareas y preparar el día siguiente. Mantener horarios de descanso lo más constantes posible puede ayudar.',
                    'Reduce la luz intensa y las pantallas justo antes de acostarte cuando puedas. Si tomas café para continuar estudiando, observa si consumirlo tarde retrasa tu sueño.',
                    'No conviertas el descanso en una recompensa que solo llega cuando terminas todo. Dormir es parte de poder aprender y sostener tus actividades.',
                ],
                'contexto' => [
                    'Al regresar tarde de clases todavía puede haber tareas, transporte, comida o responsabilidades en casa. Dormir poco se vuelve fácil de normalizar cuando todos parecen estar igual de ocupados. Sin embargo, el descanso permite recuperar energía y prestar atención al día siguiente. Necesitarlo no es falta de compromiso con tus estudios.',
                    'No existe una rutina perfecta que sirva para todas las jornadas. Los horarios de trabajo, el ruido y las obligaciones familiares pueden limitar tus opciones. En vez de culparte por no cumplir un plan ideal, observa qué cambios pequeños son posibles en tu contexto y cuáles requieren apoyo de quienes comparten contigo el tiempo o el espacio.',
                ],
                'senales' => [
                    'Te quedas dormido en clases, en el transporte o mientras estudias.',
                    'Te cuesta recordar lo recién leído y necesitas releer muchas veces.',
                    'Sientes irritabilidad o cansancio persistente al iniciar el día.',
                ],
                'acciones' => [
                    'Define una hora aproximada para cerrar el estudio y deja anotado el primer paso de mañana; así no tienes que resolver todo antes de acostarte.',
                    'Prepara con anticipación lo indispensable para salir al día siguiente, como materiales y ropa, si eso reduce las decisiones de última hora.',
                    'Observa qué hábitos de la noche te mantienen despierto y cambia uno por vez. Una rutina sencilla puede ser más sostenible que varias reglas nuevas.',
                    'Si compartes vivienda, conversa sobre momentos de menor ruido o luz. Pedir un acuerdo práctico también es una forma de cuidar el descanso.',
                ],
                'ayuda' => 'Si el sueño insuficiente o las dificultades para dormir se mantienen y afectan tu trabajo, estudio o seguridad al desplazarte, busca orientación en un servicio de salud. Puedes contar cómo son tus horarios reales, qué has intentado y cómo te sientes durante el día. Un profesional puede valorar tu situación sin reducirla a falta de voluntad.',
            ],
            [
                'categoria' => 'tiempo',
                'titulo' => 'Organiza una semana con tiempo real',
                'resumen' => 'Incluye trabajo, traslados y descanso antes de llenar tu agenda de tareas.',
                'contenido' => [
                    'Anota primero tus horarios fijos: trabajo, clases, traslados, comida y sueño. Luego identifica los espacios disponibles para estudiar. Ese tiempo real es la base de tu plan.',
                    'Elige hasta tres prioridades por día y divide los trabajos grandes en entregas pequeñas. Deja un margen para imprevistos: un plan útil se puede ajustar.',
                    'Si las fechas coinciden y no alcanzas, comunica la situación con anticipación a docentes o compañeros y pide ayuda para reorganizarte.',
                ],
                'contexto' => [
                    'Quien trabaja de día y estudia de noche puede llenar una agenda sin considerar el cansancio, los traslados o el tiempo para comer. Cuando el plan no se cumple, aparece la idea de que faltó disciplina. Muchas veces el problema es que el horario imaginado nunca estuvo disponible. Organizarse empieza por mirar la semana tal como es.',
                    'El desgaste de combinar responsabilidades no siempre se ve desde fuera. Hay tareas laborales, familiares y académicas que compiten por la misma energía. Un calendario puede ayudarte a decidir, pero no fabrica horas nuevas. Si la carga supera lo posible, ajustar una fecha, pedir colaboración o reducir temporalmente un compromiso puede ser una decisión responsable.',
                ],
                'senales' => [
                    'Pasas de una obligación a otra sin tiempo para comer o descansar.',
                    'Sientes que cualquier imprevisto desarma toda la semana.',
                    'Dejas de pedir apoyo porque piensas que deberías resolverlo todo solo.',
                ],
                'acciones' => [
                    'Marca primero trabajo, clases, transporte, comidas y descanso. Solo después ubica sesiones de estudio en los espacios que realmente quedan.',
                    'Divide una entrega grande en pasos visibles, como buscar material, hacer un borrador y revisar. Así puedes avanzar aunque dispongas de poco tiempo.',
                    'Deja un margen para retrasos o tareas inesperadas. Si no lo necesitas, podrás usarlo para descansar o adelantar sin presión.',
                    'Revisa el plan al final de la semana con curiosidad: identifica qué funcionó y qué carga conviene conversar con otras personas.',
                ],
                'ayuda' => 'Cuando la semana se vuelve insostenible, habla temprano con docentes, compañeros o familiares sobre una necesidad concreta. Puedes explicar cuántas horas tienes disponibles y preguntar qué entrega es prioritaria. Si el agotamiento o la angustia continúan pese a los ajustes, consulta por orientación estudiantil o atención profesional en tu zona.',
            ],
            [
                'categoria' => 'tiempo',
                'titulo' => 'Estudia en bloques que puedas sostener',
                'resumen' => 'Una sesión corta y enfocada puede ser más útil que horas de agotamiento.',
                'contenido' => [
                    'Antes de empezar, define una tarea concreta: resolver dos ejercicios, hacer un esquema o explicar un concepto con tus palabras. Así sabrás cuándo terminaste el bloque.',
                    'Aparta distracciones durante un rato y haz una pausa al finalizar. Ajusta la duración a tu energía; después de una jornada laboral quizá necesites un bloque más corto.',
                    'Al cerrar, anota el siguiente paso. Eso facilita retomar sin gastar tiempo en decidir por dónde comenzar.',
                ],
                'contexto' => [
                    'Después de trabajar y asistir a clases, sentarse durante horas frente a una tarea puede parecer la única manera de avanzar. Pero la atención cambia con el cansancio y con las preocupaciones que llevas a casa. Estudiar en bloques es una forma de darle un comienzo y un cierre claros a una actividad, sin exigir concentración ilimitada.',
                    'Este hábito no elimina las entregas acumuladas ni reemplaza el descanso. Sirve para hacer más visible lo que sí puedes completar hoy y para reconocer cuándo necesitas parar. Compararte con alguien que tiene otros horarios puede aumentar la presión. Tu plan necesita responder a tus condiciones reales, no a una idea perfecta de productividad.',
                ],
                'senales' => [
                    'Lees la misma página muchas veces sin comprenderla.',
                    'Te irritas al detenerte y sientes culpa por tomar una pausa.',
                    'Extiendes el estudio hasta muy tarde sin avanzar en una tarea concreta.',
                ],
                'acciones' => [
                    'Elige un resultado pequeño y observable para cada bloque, como resolver un ejercicio o resumir una idea, en lugar de “estudiar todo”.',
                    'Ten a mano lo necesario antes de comenzar. Si surge otra preocupación, anótala para atenderla luego sin perderla de vista.',
                    'Haz una pausa cuando notes que la atención cae. Caminar un poco, beber agua o cambiar de postura puede ayudarte a decidir si continúas.',
                    'Al terminar, registra lo avanzado y el siguiente paso. Si la tarea sigue siendo demasiado grande, pide ayuda para dividirla.',
                ],
                'ayuda' => 'Si, aun con ajustes, el cansancio te impide estudiar o cumplir actividades cotidianas durante un tiempo, conversa con alguien de confianza. También puedes pedir a un docente ayuda para priorizar contenidos o consultar por orientación en el instituto. Si el malestar persiste, acudir a un profesional de salud es una opción válida.',
            ],
            [
                'categoria' => 'animo',
                'titulo' => 'Háblate como hablarías a un compañero',
                'resumen' => 'Equivocarse o atrasarse no borra el esfuerzo que ya hiciste.',
                'contenido' => [
                    'Cuando algo sale mal, observa si te estás diciendo frases que no dirías a un amigo. Cambia la crítica general por una pregunta concreta: ¿qué puedo ajustar la próxima vez?',
                    'Reconoce también las condiciones en las que estás estudiando. Trabajar, trasladarte y asistir a clases consume energía; ajustar una meta puede ser una decisión responsable.',
                    'Si el desánimo dura varios días o te dificulta seguir con tu vida cotidiana, busca apoyo de alguien de confianza o de un profesional.',
                ],
                'contexto' => [
                    'Una nota baja o una tarea entregada tarde puede activar pensamientos duros: “No sirvo para esto” o “todos pueden menos yo”. Si además trabajas durante el día, quizá casi nadie vea el esfuerzo que haces para llegar a clases. La manera de hablarte influye en cómo atraviesas un error y en si encuentras fuerzas para intentarlo de nuevo.',
                    'La presión por rendir puede venir de expectativas propias, familiares o del deseo de aprovechar una oportunidad de estudio. Reconocer esa presión no significa renunciar a tus metas. Significa mirar el contexto completo y separar un resultado puntual de tu valor como persona. Tampoco tienes que resolver el agotamiento únicamente cambiando tu actitud: algunas cargas necesitan acuerdos y apoyo.',
                ],
                'senales' => [
                    'Conviertes cada error en una conclusión sobre quién eres.',
                    'Te cuesta reconocer avances porque solo miras lo que falta.',
                    'Evitas hablar de tus dificultades por miedo a decepcionar a otros.',
                ],
                'acciones' => [
                    'Describe el hecho concreto sin insultarte: “No terminé esta entrega” permite pensar un paso siguiente mejor que una etiqueta personal.',
                    'Pregunta qué influyó en el resultado: tiempo disponible, instrucciones poco claras, cansancio o necesidad de practicar más. Así podrás elegir un ajuste posible.',
                    'Reconoce una acción que sí sostuviste esta semana, aunque haya sido pequeña. Registrar avances ayuda a no mirar solo la falta.',
                    'Si una expectativa familiar te pesa, busca un momento tranquilo para explicar tu horario y conversar sobre apoyos o cambios de tareas.',
                ],
                'ayuda' => 'Cuando el desánimo permanece, afecta tus relaciones o te cuesta continuar con tu vida diaria, no esperes a tener una explicación perfecta. Puedes hablar con una persona de confianza, preguntar por orientación en el instituto o consultar a un profesional. Pedir compañía para dar ese primer paso también está bien.',
            ],
            [
                'categoria' => 'apoyo',
                'titulo' => 'Cómo empezar a pedir ayuda',
                'resumen' => 'No necesitas tener todo claro para iniciar una conversación.',
                'contenido' => [
                    'Puedes comenzar con una frase simple: “Estoy teniendo días difíciles y me gustaría hablar”. Elige a alguien con quien te sientas seguro o segura y dile qué necesitas: escucha, compañía o ayuda práctica.',
                    'Si te cuesta hablar en persona, un mensaje también puede abrir la conversación. En tu institución, pregunta si existe orientación estudiantil o apoyo psicológico.',
                    'Pedir ayuda es una forma de cuidar tu bienestar. Si la primera persona no puede ayudarte, intenta con otra persona o servicio.',
                ],
                'contexto' => [
                    'Al combinar empleo, estudios nocturnos y responsabilidades personales, puede parecer que no hay tiempo ni palabras para contar lo que pasa. Algunas personas temen preocupar a su familia o ser juzgadas por sus compañeros. Sin embargo, no necesitas demostrar que tu situación es “lo bastante grave” para pedir una conversación o información sobre apoyo.',
                    'Pedir ayuda puede significar cosas distintas: compañía para organizar una semana difícil, orientación académica, apoyo emocional o atención de salud. Elegir a quién acudir depende de lo que necesitas y de dónde te sientes respetado. No existe una frase perfecta ni una sola persona capaz de resolverlo todo. Puedes empezar con un problema concreto.',
                ],
                'senales' => [
                    'Te aíslas cuando la carga aumenta, aunque quisieras conversar.',
                    'Las preocupaciones interfieren con el sueño, las clases o el trabajo.',
                    'Sientes que debes ocultar lo que te pasa para no molestar.',
                ],
                'acciones' => [
                    'Elige una persona con quien te sientas relativamente seguro y pide un momento específico para hablar, aunque sea breve.',
                    'Si no sabes qué necesitas, dilo así. La otra persona puede escucharte primero y ayudarte a pensar opciones sin decidir por ti.',
                    'Anota dos o tres hechos concretos antes de conversar: qué cambió, desde cuándo lo notas y qué parte de tu rutina se está haciendo difícil.',
                    'Pregunta en el instituto qué espacios de orientación existen. Si no hay uno disponible, consulta en un servicio de salud de tu zona.',
                ],
                'ayuda' => 'Busca apoyo profesional cuando el malestar persiste, aumenta o limita tu vida cotidiana. Puedes acudir acompañado si eso facilita el primer contacto. Si la primera respuesta no te resulta útil, tienes derecho a buscar otra opción. Ante una situación de peligro inmediato, acude a un servicio de emergencia presencial cercano.',
            ],
            [
                'categoria' => 'apoyo',
                'titulo' => 'Construye una red de apoyo posible',
                'resumen' => 'Identifica personas y espacios a los que puedas acudir durante semanas exigentes.',
                'contenido' => [
                    'Piensa en dos personas con quienes podrías conversar y en un recurso de tu institución, como tutoría, bienestar estudiantil u orientación. Guarda sus datos donde puedas encontrarlos.',
                    'También puedes acordar con un compañero una revisión breve de avances antes de una entrega. Acompañarse no significa resolver las tareas del otro.',
                    'Una red se construye con pasos pequeños. Si ahora te sientes aislado o aislada, empieza por una conversación sencilla y busca espacios donde te traten con respeto.',
                ],
                'contexto' => [
                    'Al estudiar de noche, muchas relaciones se reducen a saludos rápidos antes de entrar a clase o a mensajes sobre tareas. Si surge una semana difícil, quizá no sepas a quién escribir. Una red de apoyo no tiene que ser grande: puede reunir personas distintas para conversar, estudiar, resolver una gestión o acompañarte a buscar atención.',
                    'La ayuda también necesita límites. Un compañero puede compartir apuntes, pero quizá no puede atender una conversación larga después de su propio turno de trabajo. Reconocerlo evita sentir rechazo cuando alguien no está disponible. Contar con varias opciones y preguntar qué puede ofrecer cada persona hace la red más realista y respetuosa.',
                ],
                'senales' => [
                    'Atraviesas dificultades sin contarle a nadie porque temes ser una carga.',
                    'Dependes de una sola persona para todas tus necesidades de apoyo.',
                    'No sabes dónde consultar cuando necesitas orientación académica o de salud.',
                ],
                'acciones' => [
                    'Haz una lista corta de personas y espacios posibles: alguien de confianza, un compañero, un docente y un servicio de salud cercano.',
                    'Pregunta antes de contar algo sensible: “¿Tienes un momento para escucharme?”. Así cuidas tu necesidad y el tiempo de la otra persona.',
                    'Propón un acuerdo concreto de estudio, como revisar dudas antes de una entrega o compartir un calendario, sin asumir que el otro hará tu trabajo.',
                    'Actualiza tus contactos cuando cambien tus horarios o tu situación. Una red útil se ajusta con el tiempo y puede incluir nuevos vínculos.',
                ],
                'ayuda' => 'Si te sientes aislado, agotado o sin una persona segura a quien acudir, pregunta en el instituto qué orientación existe o consulta a un profesional de salud. Puedes comenzar diciendo que necesitas hablar y no sabes por dónde empezar. Si hay peligro inmediato, busca atención de emergencia presencial en tu zona. No tienes que esperar a estar al límite para pedir apoyo.',
            ],
        ];

        $parrafo = fn (string $texto): string => '<p>'.e($texto).'</p>';
        $lista = fn (array $elementos): string => '<ul>'.implode('', array_map(
            fn (string $texto): string => '<li>'.e($texto).'</li>',
            $elementos
        )).'</ul>';

        foreach ($articulos as $articulo) {
            $contenido = implode("\n", [
                $parrafo($articulo['contenido'][0]),
                '<h2>Entender lo que pasa</h2>',
                ...array_map($parrafo, $articulo['contexto']),
                '<h2>Señales para prestar atención</h2>',
                $lista($articulo['senales']),
                '<h2>Qué puedes hacer</h2>',
                $parrafo($articulo['contenido'][1]),
                $lista($articulo['acciones']),
                '<h2>Cuándo y cómo pedir ayuda</h2>',
                $parrafo($articulo['contenido'][2]),
                $parrafo($articulo['ayuda']),
                '<p>Este sitio es orientativo y no reemplaza la atención de un profesional.</p>',
                '<h2>Para saber más</h2>',
                $lista([
                    'Organización Mundial de la Salud (OMS) — enlace: COMPLETAR: verificar fuente',
                    'Organización Panamericana de la Salud (OPS) — enlace: COMPLETAR: verificar fuente',
                ]),
            ]);

            Articulo::updateOrCreate(
                ['titulo' => $articulo['titulo']],
                [
                    'resumen' => $articulo['resumen'],
                    'contenido' => $contenido,
                    'categoria' => $articulo['categoria'],
                ]
            );
        }
    }
}
