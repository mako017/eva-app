export interface RawResults {
	datum: string;
	zeit: string;
	wertung: number;
	session: number;
}
export interface SingleResult {
	session: number;
	mean: number;
	sd: number;
	N: number;
	A: number;
	B: number;
	C: number;
	D: number;
	E: number;
}
export class EvaResult {
	private rawResults: Array<RawResults>;
	private results: Array<SingleResult>;
	constructor(raw: Array<RawResults>) {
		this.rawResults = raw;
		this.results = [];
	}
	private countVotes(): void {
		this.rawResults.forEach(vote => {
			const resultIndex = this.results.findIndex(res => res.session === vote.session);
			if (resultIndex !== -1) {
				this.results[resultIndex].N += 1;
				switch (vote.wertung) {
					case 1:
						this.results[resultIndex].A += 1;
						break;
					case 2:
						this.results[resultIndex].B += 1;
						break;
					case 3:
						this.results[resultIndex].C += 1;
						break;
					case 4:
						this.results[resultIndex].D += 1;
						break;
					case 5:
						this.results[resultIndex].E += 1;
						break;
					default:
						break;
				}
			} else {
				this.results.push({
					session: vote.session,
					mean: 0,
					sd: 0,
					N: 1,
					A: vote.wertung === 1 ? 1 : 0,
					B: vote.wertung === 2 ? 1 : 0,
					C: vote.wertung === 3 ? 1 : 0,
					D: vote.wertung === 4 ? 1 : 0,
					E: vote.wertung === 5 ? 1 : 0,
				});
			}
		});
		this.results.forEach(result => {
			result.mean = (result.A + result.B * 2 + result.C * 3 + result.D * 4 + result.E * 5) / result.N;
			result.mean = Math.round(result.mean * 100) / 100;
			result.sd = Math.sqrt(
				((1 - result.mean) ** 2 * result.A + (2 - result.mean) ** 2 * result.B + (3 - result.mean) ** 2 * result.C + (4 - result.mean) ** 2 * result.D + (5 - result.mean) ** 2 * result.E) / result.N,
			);
			result.sd = Math.round(result.sd * 100) / 100;
		});
	}
	compute() {
		console.log(this.rawResults);

		this.countVotes();
		return this.results;
	}
}
