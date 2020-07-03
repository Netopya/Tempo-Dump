export default function renderTime(seconds) {
	if (isNaN(seconds)) {
		return '';
	}

	let h = Math.floor(seconds / 3600);
	let m = Math.floor(seconds % 3600 / 60);

	let output = [];

	if (h) {
		output.push(h + 'h');
	}

	if (m) {
		output.push(m + 'm');
	}

	return output.join(' ');
}