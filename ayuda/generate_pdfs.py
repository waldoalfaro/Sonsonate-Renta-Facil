from reportlab.lib.pagesizes import letter
from reportlab.platypus import SimpleDocTemplate, Paragraph, Spacer, PageBreak, Table, TableStyle
from reportlab.lib.styles import getSampleStyleSheet, ParagraphStyle
from reportlab.lib.units import inch
from reportlab.lib.enums import TA_CENTER, TA_JUSTIFY
from reportlab.lib import colors

def create_manual_cliente():
    doc = SimpleDocTemplate("manuales/manual-cliente.pdf", pagesize=letter)
    flowables = []
    styles = getSampleStyleSheet()
    
    title_style = ParagraphStyle(
        name='CustomTitle',
        parent=styles['Heading1'],
        fontSize=24,
        textColor=colors.HexColor('#D4AF37'),
        alignment=TA_CENTER,
        spaceAfter=30
    )
    
    subtitle_style = ParagraphStyle(
        name='Subtitle',
        parent=styles['Heading2'],
        fontSize=16,
        textColor=colors.HexColor('#1a1a1a'),
        spaceAfter=12
    )
    
    flowables.append(Paragraph("MANUAL DE USUARIO - CLIENTE", title_style))
    flowables.append(Paragraph("Sistema de Renta de Vehículos", styles['Heading2']))
    flowables.append(Spacer(1, 0.5*inch))
    
    flowables.append(Paragraph("1. Introducción", subtitle_style))
    flowables.append(Paragraph(
        "Bienvenido al Sistema de Renta de Vehículos. Este manual le guiará a través de todas las "
        "funcionalidades disponibles para los clientes de nuestra plataforma. Aprenderá a navegar "
        "por el sistema, realizar reservas, gestionar sus vehículos rentados y mucho más.",
        styles['BodyText']
    ))
    flowables.append(Spacer(1, 0.3*inch))
    
    flowables.append(Paragraph("2. Registro y Acceso", subtitle_style))
    flowables.append(Paragraph(
        "<b>2.1 Crear una cuenta:</b> Para comenzar a usar el sistema, debe crear una cuenta de cliente. "
        "Haga clic en el botón 'Registrarse' en la página principal e ingrese sus datos personales, "
        "incluyendo nombre completo, correo electrónico, teléfono y dirección.",
        styles['BodyText']
    ))
    flowables.append(Spacer(1, 0.2*inch))
    
    flowables.append(Paragraph(
        "<b>2.2 Iniciar sesión:</b> Una vez registrado, puede acceder al sistema usando su correo "
        "electrónico y contraseña. Marque la opción 'Recordarme' para mantener su sesión activa.",
        styles['BodyText']
    ))
    flowables.append(Spacer(1, 0.3*inch))
    
    flowables.append(Paragraph("3. Búsqueda y Selección de Vehículos", subtitle_style))
    flowables.append(Paragraph(
        "<b>3.1 Búsqueda de vehículos:</b> Utilice los filtros de búsqueda para encontrar el vehículo "
        "perfecto para sus necesidades. Puede filtrar por tipo de vehículo (sedán, SUV, camioneta), "
        "rango de precios, características especiales y disponibilidad de fechas.",
        styles['BodyText']
    ))
    flowables.append(Spacer(1, 0.2*inch))
    
    flowables.append(Paragraph(
        "<b>3.2 Detalles del vehículo:</b> Haga clic en cualquier vehículo para ver información "
        "detallada como especificaciones técnicas, fotografías, precio por día, seguro incluido "
        "y términos y condiciones específicos.",
        styles['BodyText']
    ))
    flowables.append(Spacer(1, 0.3*inch))
    
    flowables.append(Paragraph("4. Realizar una Reserva", subtitle_style))
    flowables.append(Paragraph(
        "<b>4.1 Proceso de reserva:</b> Seleccione las fechas de inicio y fin de su renta, "
        "verifique la disponibilidad y haga clic en 'Reservar Ahora'. El sistema calculará "
        "automáticamente el costo total incluyendo impuestos y cargos adicionales.",
        styles['BodyText']
    ))
    flowables.append(Spacer(1, 0.2*inch))
    
    flowables.append(Paragraph(
        "<b>4.2 Métodos de pago:</b> Aceptamos tarjetas de crédito/débito (Visa, MasterCard, "
        "American Express) y transferencias bancarias. Todos los pagos son procesados de forma "
        "segura mediante encriptación SSL.",
        styles['BodyText']
    ))
    flowables.append(Spacer(1, 0.3*inch))
    
    flowables.append(Paragraph("5. Gestión de Reservas", subtitle_style))
    flowables.append(Paragraph(
        "<b>5.1 Mis reservas:</b> Acceda a la sección 'Mis Reservas' desde el menú principal "
        "para ver todas sus reservas activas, historial y reservas futuras. Puede modificar o "
        "cancelar reservas según las políticas establecidas.",
        styles['BodyText']
    ))
    flowables.append(Spacer(1, 0.2*inch))
    
    flowables.append(Paragraph(
        "<b>5.2 Modificaciones:</b> Para modificar una reserva, selecciónela y haga clic en "
        "'Modificar'. Puede cambiar fechas o actualizar información de contacto hasta 24 horas "
        "antes de la fecha de inicio.",
        styles['BodyText']
    ))
    flowables.append(Spacer(1, 0.3*inch))
    
    flowables.append(Paragraph("6. Recogida y Devolución", subtitle_style))
    flowables.append(Paragraph(
        "<b>6.1 Recogida del vehículo:</b> Llegue a la sucursal en la fecha y hora acordadas "
        "con su identificación oficial y confirmación de reserva. Un empleado le entregará las "
        "llaves y verificará el estado del vehículo con usted.",
        styles['BodyText']
    ))
    flowables.append(Spacer(1, 0.2*inch))
    
    flowables.append(Paragraph(
        "<b>6.2 Devolución:</b> Devuelva el vehículo en la misma sucursal o en la ubicación "
        "acordada. Asegúrese de que el tanque de combustible esté lleno y el vehículo limpio "
        "para evitar cargos adicionales.",
        styles['BodyText']
    ))
    flowables.append(Spacer(1, 0.3*inch))
    
    flowables.append(Paragraph("7. Soporte y Asistencia", subtitle_style))
    flowables.append(Paragraph(
        "Si tiene alguna pregunta o problema, nuestro equipo de soporte está disponible 24/7. "
        "Puede contactarnos por teléfono, correo electrónico o chat en vivo desde la plataforma. "
        "Para emergencias durante la renta, llame al número de asistencia vial incluido en su contrato.",
        styles['BodyText']
    ))
    
    doc.build(flowables)

def create_manual_administrador():
    doc = SimpleDocTemplate("manuales/manual-administrador.pdf", pagesize=letter)
    flowables = []
    styles = getSampleStyleSheet()
    
    title_style = ParagraphStyle(
        name='CustomTitle',
        parent=styles['Heading1'],
        fontSize=24,
        textColor=colors.HexColor('#D4AF37'),
        alignment=TA_CENTER,
        spaceAfter=30
    )
    
    subtitle_style = ParagraphStyle(
        name='Subtitle',
        parent=styles['Heading2'],
        fontSize=16,
        textColor=colors.HexColor('#1a1a1a'),
        spaceAfter=12
    )
    
    flowables.append(Paragraph("MANUAL DE ADMINISTRADOR", title_style))
    flowables.append(Paragraph("Sistema de Renta de Vehículos", styles['Heading2']))
    flowables.append(Spacer(1, 0.5*inch))
    
    flowables.append(Paragraph("1. Panel de Administración", subtitle_style))
    flowables.append(Paragraph(
        "Como administrador del sistema, usted tiene acceso completo a todas las funcionalidades "
        "administrativas. El panel de control le proporciona una vista general del estado del negocio, "
        "incluyendo reservas activas, ingresos del día, vehículos disponibles y métricas clave de rendimiento.",
        styles['BodyText']
    ))
    flowables.append(Spacer(1, 0.3*inch))
    
    flowables.append(Paragraph("2. Gestión de Vehículos", subtitle_style))
    flowables.append(Paragraph(
        "<b>2.1 Agregar vehículos:</b> Para agregar un nuevo vehículo al inventario, navegue a "
        "'Vehículos' > 'Agregar Nuevo'. Complete todos los campos requeridos: marca, modelo, año, "
        "placa, color, kilometraje, precio por día, tipo de combustible y características especiales.",
        styles['BodyText']
    ))
    flowables.append(Spacer(1, 0.2*inch))
    
    flowables.append(Paragraph(
        "<b>2.2 Editar vehículos:</b> Seleccione cualquier vehículo de la lista para editar su "
        "información, actualizar precios, modificar disponibilidad o agregar fotografías. Los cambios "
        "se reflejan inmediatamente en el sistema.",
        styles['BodyText']
    ))
    flowables.append(Spacer(1, 0.2*inch))
    
    flowables.append(Paragraph(
        "<b>2.3 Mantenimiento:</b> Registre todas las actividades de mantenimiento preventivo y "
        "correctivo. El sistema le alertará cuando un vehículo requiera servicio basándose en "
        "kilometraje o tiempo transcurrido.",
        styles['BodyText']
    ))
    flowables.append(Spacer(1, 0.3*inch))
    
    flowables.append(Paragraph("3. Gestión de Usuarios", subtitle_style))
    flowables.append(Paragraph(
        "<b>3.1 Clientes:</b> Visualice y administre todos los clientes registrados. Puede ver "
        "el historial de rentas, verificar documentación, aprobar o rechazar solicitudes y gestionar "
        "cuentas problemáticas.",
        styles['BodyText']
    ))
    flowables.append(Spacer(1, 0.2*inch))
    
    flowables.append(Paragraph(
        "<b>3.2 Empleados:</b> Cree cuentas para empleados, asigne roles y permisos específicos. "
        "Puede establecer diferentes niveles de acceso según las responsabilidades de cada empleado "
        "(recepcionista, mecánico, supervisor, etc.).",
        styles['BodyText']
    ))
    flowables.append(Spacer(1, 0.3*inch))
    
    flowables.append(Paragraph("4. Administración de Reservas", subtitle_style))
    flowables.append(Paragraph(
        "<b>4.1 Visualización:</b> Acceda a todas las reservas del sistema con filtros por estado "
        "(pendiente, confirmada, en curso, completada, cancelada), fechas, cliente o vehículo. "
        "La vista de calendario le permite visualizar la ocupación de la flota.",
        styles['BodyText']
    ))
    flowables.append(Spacer(1, 0.2*inch))
    
    flowables.append(Paragraph(
        "<b>4.2 Modificación manual:</b> Los administradores pueden modificar reservas existentes, "
        "extender períodos de renta, aplicar descuentos especiales o resolver conflictos de reservas.",
        styles['BodyText']
    ))
    flowables.append(Spacer(1, 0.3*inch))
    
    flowables.append(Paragraph("5. Reportes y Estadísticas", subtitle_style))
    flowables.append(Paragraph(
        "<b>5.1 Reportes financieros:</b> Genere reportes detallados de ingresos por día, semana, "
        "mes o período personalizado. Incluye desglose por tipo de vehículo, sucursal y método de pago.",
        styles['BodyText']
    ))
    flowables.append(Spacer(1, 0.2*inch))
    
    data = [
        ['Reporte', 'Descripción', 'Frecuencia'],
        ['Ingresos', 'Ingresos totales y desglosados', 'Diario/Mensual'],
        ['Ocupación', 'Tasa de ocupación de flota', 'Semanal'],
        ['Clientes', 'Nuevos clientes y retención', 'Mensual'],
        ['Mantenimiento', 'Costos y programación', 'Trimestral']
    ]
    
    table = Table(data, colWidths=[2*inch, 2.5*inch, 1.5*inch])
    table.setStyle(TableStyle([
        ('BACKGROUND', (0, 0), (-1, 0), colors.HexColor('#D4AF37')),
        ('TEXTCOLOR', (0, 0), (-1, 0), colors.HexColor('#1a1a1a')),
        ('ALIGN', (0, 0), (-1, -1), 'CENTER'),
        ('FONTNAME', (0, 0), (-1, 0), 'Helvetica-Bold'),
        ('FONTSIZE', (0, 0), (-1, 0), 10),
        ('BACKGROUND', (0, 1), (-1, -1), colors.beige),
        ('GRID', (0, 0), (-1, -1), 1, colors.black)
    ]))
    
    flowables.append(table)
    flowables.append(Spacer(1, 0.3*inch))
    
    flowables.append(Paragraph("6. Configuración del Sistema", subtitle_style))
    flowables.append(Paragraph(
        "<b>6.1 Parámetros generales:</b> Configure precios base, porcentajes de impuestos, "
        "políticas de cancelación, horarios de operación y notificaciones automáticas del sistema.",
        styles['BodyText']
    ))
    flowables.append(Spacer(1, 0.2*inch))
    
    flowables.append(Paragraph(
        "<b>6.2 Seguridad:</b> Gestione políticas de seguridad, configure autenticación de dos "
        "factores, revise logs de acceso y administre permisos de usuario. Se recomienda cambiar "
        "contraseñas administrativas cada 90 días.",
        styles['BodyText']
    ))
    flowables.append(Spacer(1, 0.3*inch))
    
    flowables.append(Paragraph("7. Respaldo y Mantenimiento", subtitle_style))
    flowables.append(Paragraph(
        "El sistema realiza respaldos automáticos diarios de toda la información. Como administrador, "
        "puede iniciar respaldos manuales, restaurar datos de respaldos anteriores y programar "
        "mantenimiento del sistema en horarios de baja demanda.",
        styles['BodyText']
    ))
    
    doc.build(flowables)

def create_manual_empleado():
    doc = SimpleDocTemplate("manuales/manual-empleado.pdf", pagesize=letter)
    flowables = []
    styles = getSampleStyleSheet()
    
    title_style = ParagraphStyle(
        name='CustomTitle',
        parent=styles['Heading1'],
        fontSize=24,
        textColor=colors.HexColor('#D4AF37'),
        alignment=TA_CENTER,
        spaceAfter=30
    )
    
    subtitle_style = ParagraphStyle(
        name='Subtitle',
        parent=styles['Heading2'],
        fontSize=16,
        textColor=colors.HexColor('#1a1a1a'),
        spaceAfter=12
    )
    
    flowables.append(Paragraph("MANUAL DE EMPLEADO", title_style))
    flowables.append(Paragraph("Sistema de Renta de Vehículos", styles['Heading2']))
    flowables.append(Spacer(1, 0.5*inch))
    
    flowables.append(Paragraph("1. Bienvenida al Equipo", subtitle_style))
    flowables.append(Paragraph(
        "Como empleado del Sistema de Renta de Vehículos, usted es un elemento fundamental para "
        "garantizar la satisfacción de nuestros clientes. Este manual le guiará en sus "
        "responsabilidades diarias y le ayudará a utilizar eficientemente las herramientas del sistema.",
        styles['BodyText']
    ))
    flowables.append(Spacer(1, 0.3*inch))
    
    flowables.append(Paragraph("2. Acceso al Sistema", subtitle_style))
    flowables.append(Paragraph(
        "<b>2.1 Inicio de sesión:</b> Utilice las credenciales proporcionadas por su supervisor "
        "para acceder al sistema. Su cuenta de empleado le da acceso a las funciones necesarias "
        "para realizar su trabajo diario.",
        styles['BodyText']
    ))
    flowables.append(Spacer(1, 0.2*inch))
    
    flowables.append(Paragraph(
        "<b>2.2 Interfaz de empleado:</b> La interfaz está diseñada para facilitar sus tareas más "
        "comunes: registro de entregas, recepciones, consulta de reservas y comunicación con clientes.",
        styles['BodyText']
    ))
    flowables.append(Spacer(1, 0.3*inch))
    
    flowables.append(Paragraph("3. Proceso de Entrega de Vehículos", subtitle_style))
    flowables.append(Paragraph(
        "<b>3.1 Preparación:</b> Antes de la llegada del cliente, verifique que el vehículo esté "
        "limpio, con el tanque lleno y en perfectas condiciones mecánicas. Revise que todos los "
        "accesorios estén presentes (gato, llave de ruedas, documentos, etc.).",
        styles['BodyText']
    ))
    flowables.append(Spacer(1, 0.2*inch))
    
    flowables.append(Paragraph(
        "<b>3.2 Inspección con el cliente:</b> Realice una inspección visual completa del vehículo "
        "junto con el cliente. Documente cualquier daño existente tomando fotografías y registrándolo "
        "en el sistema. El cliente debe firmar el reporte de inspección.",
        styles['BodyText']
    ))
    flowables.append(Spacer(1, 0.2*inch))
    
    flowables.append(Paragraph(
        "<b>3.3 Documentación:</b> Verifique que el cliente presente identificación oficial vigente, "
        "licencia de conducir válida y tarjeta de crédito para el depósito de seguridad. Escanee "
        "todos los documentos en el sistema.",
        styles['BodyText']
    ))
    flowables.append(Spacer(1, 0.2*inch))
    
    flowables.append(Paragraph(
        "<b>3.4 Explicación al cliente:</b> Explique las características del vehículo, controles "
        "básicos, política de combustible, números de emergencia y procedimiento en caso de accidente. "
        "Entregue las llaves y la documentación del vehículo.",
        styles['BodyText']
    ))
    flowables.append(Spacer(1, 0.3*inch))
    
    flowables.append(Paragraph("4. Proceso de Recepción de Vehículos", subtitle_style))
    flowables.append(Paragraph(
        "<b>4.1 Inspección de retorno:</b> Al recibir el vehículo, realice una inspección completa "
        "comparando con el reporte de entrega. Verifique nivel de combustible, limpieza, daños nuevos "
        "y funcionamiento de todos los sistemas.",
        styles['BodyText']
    ))
    flowables.append(Spacer(1, 0.2*inch))
    
    flowables.append(Paragraph(
        "<b>4.2 Registro en el sistema:</b> Registre la devolución en el sistema indicando el "
        "kilometraje final, estado del vehículo y cualquier cargo adicional (combustible faltante, "
        "limpieza, daños). El sistema calculará automáticamente los cargos.",
        styles['BodyText']
    ))
    flowables.append(Spacer(1, 0.2*inch))
    
    flowables.append(Paragraph(
        "<b>4.3 Cierre de la renta:</b> Procese el pago de cargos adicionales si los hay, libere "
        "el depósito de seguridad y proporcione al cliente el recibo final. Solicite feedback sobre "
        "su experiencia.",
        styles['BodyText']
    ))
    flowables.append(Spacer(1, 0.3*inch))
    
    flowables.append(Paragraph("5. Lista de Verificación", subtitle_style))
    
    data = [
        ['Item', 'Entrega', 'Recepción'],
        ['Limpieza exterior', '✓', '✓'],
        ['Limpieza interior', '✓', '✓'],
        ['Nivel de combustible', 'Lleno', 'Verificar'],
        ['Documentos del vehículo', '✓', '✓'],
        ['Llanta de refacción', '✓', '✓'],
        ['Herramientas', '✓', '✓'],
        ['Fotografías', '✓', '✓'],
        ['Firma del cliente', '✓', '✓']
    ]
    
    table = Table(data, colWidths=[2.5*inch, 1.5*inch, 1.5*inch])
    table.setStyle(TableStyle([
        ('BACKGROUND', (0, 0), (-1, 0), colors.HexColor('#D4AF37')),
        ('TEXTCOLOR', (0, 0), (-1, 0), colors.HexColor('#1a1a1a')),
        ('ALIGN', (0, 0), (-1, -1), 'CENTER'),
        ('FONTNAME', (0, 0), (-1, 0), 'Helvetica-Bold'),
        ('FONTSIZE', (0, 0), (-1, 0), 10),
        ('BACKGROUND', (0, 1), (-1, -1), colors.beige),
        ('GRID', (0, 0), (-1, -1), 1, colors.black)
    ]))
    
    flowables.append(table)
    flowables.append(Spacer(1, 0.3*inch))
    
    flowables.append(Paragraph("6. Atención al Cliente", subtitle_style))
    flowables.append(Paragraph(
        "<b>6.1 Comunicación profesional:</b> Mantenga siempre una actitud profesional, amable y "
        "servicial. Escuche atentamente las necesidades del cliente y responda sus preguntas con claridad.",
        styles['BodyText']
    ))
    flowables.append(Spacer(1, 0.2*inch))
    
    flowables.append(Paragraph(
        "<b>6.2 Resolución de problemas:</b> Si un cliente reporta un problema, documente todos "
        "los detalles en el sistema y notifique inmediatamente a su supervisor. No prometa soluciones "
        "que excedan su autoridad.",
        styles['BodyText']
    ))
    flowables.append(Spacer(1, 0.3*inch))
    
    flowables.append(Paragraph("7. Seguridad y Procedimientos", subtitle_style))
    flowables.append(Paragraph(
        "<b>7.1 Manejo de efectivo:</b> Todo pago en efectivo debe registrarse inmediatamente en el "
        "sistema y depositarse en la caja fuerte siguiendo el protocolo establecido.",
        styles['BodyText']
    ))
    flowables.append(Spacer(1, 0.2*inch))
    
    flowables.append(Paragraph(
        "<b>7.2 Seguridad de las llaves:</b> Las llaves de los vehículos deben almacenarse en el "
        "tablero de llaves cuando no estén en uso. Nunca deje llaves sin supervisión.",
        styles['BodyText']
    ))
    flowables.append(Spacer(1, 0.2*inch))
    
    flowables.append(Paragraph(
        "<b>7.3 Emergencias:</b> En caso de emergencia, siga el protocolo de evacuación y notifique "
        "al gerente inmediatamente. Los números de emergencia están disponibles en el sistema.",
        styles['BodyText']
    ))
    
    doc.build(flowables)

if __name__ == "__main__":
    print("Generando Manual de Cliente...")
    create_manual_cliente()
    print("✓ Manual de Cliente generado")
    
    print("Generando Manual de Administrador...")
    create_manual_administrador()
    print("✓ Manual de Administrador generado")
    
    print("Generando Manual de Empleado...")
    create_manual_empleado()
    print("✓ Manual de Empleado generado")
    
    print("\n¡Todos los manuales PDF han sido generados exitosamente!")
