const utils = {
	handleInput: (value, setter) => ({
		value,
		onChange: (e) => setter(e.target.value),
	}),
};

function Card({ children }) {
	return (
		<div className='bg-white w-4/5 rounded-md shadow-md mt-16 p-5 flex flex-col gap-2'>
			{children}
		</div>
	);
}

function CardHeader({ title, subtitle }) {
	return (
		<h1 className='text-rose-600 text-2xl font-bold'>
			{title}
			{subtitle && (
				<span className='text-slate-400 text-lg ml-1 font-normal'>
					{subtitle}
				</span>
			)}
		</h1>
	);
}

function CardBody({ children }) {
	return <div className='flex flex-col gap-2 px-3'>{children}</div>;
}

function CardActions({ children }) {
	return (
		<div className='flex flex-row justify-end items-center gap-2 pt-4'>
			{children}
		</div>
	);
}

function ButtonPrimary({ children, ...props }) {
	return (
		<button
			{...props}
			className='p-3 rounded-md text-white bg-rose-600 hover:bg-rose-700 active:bg-rose-800 focus:ring-2 focus:ring-rose-400'
		>
			{children}
		</button>
	);
}

function ButtonSecondary({ children, ...props }) {
	return (
		<button
			{...props}
			className='p-3 rounded-md text-slate-800 bg-slate-100 hover:bg-slate-200 active:bg-slate-300 focus:ring-2 focus:ring-slate-200'
		>
			{children}
		</button>
	);
}

function Divider() {
	return <div className='h-px bg-slate-300'></div>;
}

function ColRow({ children, isCol }) {
	return isCol ? <Column children={children} /> : <Row children={children} />;
}

function Row({ children, classes }) {
	return <div className={'flex flex-row gap-4 ' + classes}>{children}</div>;
}

function Column({ children, classes }) {
	return <div className={'flex flex-col gap-4 ' + classes}>{children}</div>;
}

function SelectField({ label, options, inline, ...props }) {
	return (
		<div
			className={
				inline
					? 'flex-1 flex flex-row gap-2 items-center'
					: 'flex-1 flex flex-col gap-2'
			}
		>
			<label className={'text-sm ' + (inline ? 'flex-1' : '')}>
				{label}
			</label>
			<select
				className={
					'outline-none rounded-lg p-2 border-2 border-slate-300 focus:border-slate-400 ' +
					(inline ? 'flex-1' : '')
				}
				{...props}
			>
				{options.map((v) => (
					<option key={v.value} value={v.value}>
						{v.label}
					</option>
				))}
			</select>
		</div>
	);
}

function InputField({ label, inline, append, ...props }) {
	return (
		<div
			className={
				inline
					? 'flex-1 flex flex-row gap-2 items-center'
					: 'flex-1 flex flex-col gap-2'
			}
		>
			<label className={'text-sm ' + (inline ? 'flex-1' : '')}>
				{label}
			</label>
			<input
				className={
					'outline-none rounded-lg p-2 border-2 border-slate-300 focus:border-slate-400 ' +
					(inline ? 'flex-1' : '')
				}
				{...props}
			/>
			{inline && append ? append : <></>}
		</div>
	);
}

function Subtitle({ children }) {
	return <h2 className='text-xl text-slate-700'>{children}</h2>;
}
