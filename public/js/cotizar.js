(function () {
	const { useState } = React;

	const titles = {
		0: 'Cotizar envio',
	};
	const sizes = [
		{ value: 0, label: 'Sobre para documentos', data: [10, 1, 10] },
		{
			value: 1,
			label: 'Caja pequeña (15cm x 15cm x 15cm)',
			data: [15, 15, 15],
		},
		{
			value: 2,
			label: 'Caja mediana (25cm x 25cm x 25cm)',
			data: [25, 25, 25],
		},
		{
			value: 3,
			label: 'Caja grande (40cm x 40cm x 40cm)',
			data: [40, 40, 40],
		},
	];
	const tiposRecoleccion = [
		{
			value: 0,
			label: 'Recolectar a domicilio, entregar a domicilio',
		},
		{
			value: 1,
			label: 'Recolectar a domicilio, entregar en sucursal',
		},
		{
			value: 2,
			label: 'Recolectar en sucursal, entregar a domicilio',
		},
		{
			value: 3,
			label: 'Recolectar en surcursal, entregar en sucursal',
		},
	];

	function App() {
		const [step, setStep] = useState(0);
		const [size, setSize] = useState(0);
		const [weight, setWeight] = useState(1);
		const [type, setType] = useState(2);

        console.log(type);

		return (
			<main className='flex justify-center'>
				<Card>
					<CardHeader title={titles[step]} />
					<CardBody>
						<Row>
							<SelectField
								label='Tamaño del paquete:'
								options={sizes}
								{...utils.handleInput(size, setSize)}
							/>
							<InputField
								type='number'
								min={0.001}
								max={50}
								label='Peso en Kg (Peso máximo: 50 kg):'
								{...utils.handleInput(weight, setWeight)}
							/>
						</Row>
						<Row>
							<SelectField
								label='Opciones de recolección y entrega'
								options={tiposRecoleccion}
								{...utils.handleInput(type, setType)}
							/>
						</Row>
						<ColRow isCol={[1, 2, 3].includes(parseInt(type))}>
							<Column classes={'flex-1'}>
								<Subtitle>Remitente</Subtitle>
								<Divider />
							</Column>
							<Column classes={'flex-1'}>
								<Subtitle>Destinatario</Subtitle>
								<Divider />
							</Column>
						</ColRow>
					</CardBody>
					<CardActions>
						<ButtonSecondary>Cancelar</ButtonSecondary>
						<ButtonPrimary>Cotizar</ButtonPrimary>
					</CardActions>
				</Card>
			</main>
		);
	}

	ReactDOM.render(<App />, document.getElementById('root'));
})();
