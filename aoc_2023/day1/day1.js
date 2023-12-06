class Day1 {
    static INPUT = "./input.txt";
    constructor() {}
    static Solve1() {
        fetch(Day1.INPUT)
            .then((response) => response.text())
            .then((data) => {
                let lines = data.split(/\r?\n/);
                let result = lines.reduce((accu, line) => {
                    let value = 0;
                    let matches = [...line.matchAll(/\d/g)]; // To handle regex Iterator as an array
                    if (matches.length > 0) {
                        value = parseInt(`${matches[0]}${matches[matches.length - 1]}`, 10);
                    }
                    return accu + value;
                }, 0);
                // end
                document.getElementById("results").innerHTML = `Part 1: ${result}<br>`;
            })
            .catch((error) => console.error("Error:", error));
    }
    static Solve2() {
        const digits = ["zero", "one", "two", "three", "four", "five", "six", "seven", "eight", "nine"];
        fetch(Day1.INPUT)
            .then((response) => response.text())
            .then((data) => {
                let lines = data.split(/\r?\n/);
                let result = lines.reduce((accu, line) => {
                    let value = 0;

                    const indexesOfFirst = digits.map((elt) => line.indexOf(elt));
                    const indexesOfLast = digits.map((elt) => line.lastIndexOf(elt));
                    let digitMatches = indexesOfFirst
                        .filter((value) => value > -1)
                        .sort(function (a, b) {
                            return a - b;
                        });
                    let digitMatchesR = indexesOfLast
                        .filter((value) => value > -1)
                        .sort(function (a, b) {
                            return b - a;
                        });

                    let digit = 0;
                    if (digitMatches.length > 0) {
                        digit = indexesOfFirst.indexOf(digitMatches[0]);
                        line = [line.slice(0, digitMatches[0]), digit, line.slice(digitMatches[0])].join("");
                    }

                    if (digitMatchesR.length > 0) {
                        digit = indexesOfLast.indexOf(digitMatchesR[0]);
                        line = [line.slice(0, digitMatchesR[0] + digits[digit].length + 1), digit, line.slice(digitMatchesR[0] + digits[digit].length + 1)].join("");
                    }

                    let matches = [...line.matchAll(/\d/g)]; // To handle regex Iterator as an array
                    if (matches.length > 0) {
                        value = parseInt(`${matches[0]}${matches[matches.length - 1]}`, 10);
                    }
                    return accu + value;
                }, 0);
                // end
                document.getElementById("results").innerHTML = document.getElementById("results").innerHTML + `Part 2: ${result}<br>`;
            })
            .catch((error) => console.error("Error:", error));
    }
}

export const SolvePart1 = Day1.Solve1;
export const SolvePart2 = Day1.Solve2;
export default Day1;
