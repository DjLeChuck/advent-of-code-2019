public class Puzzle1 : Puzzle {
    const char Up = '(';
    const char Down = ')';
    const int BasementFloor = -1;

    protected override byte _day { get { return 1; } }

    public override Puzzle Solve(string input) {
        var instructionFloor = 0;
        var basementPosition = -1;

        for (int i = 0, len = input.Length; i < len; i++) {
            var c = input[i];

            if (c == Up) {
                instructionFloor++;
            } else if (c == Down) {
                instructionFloor--;

                if (basementPosition == -1 && instructionFloor == BasementFloor) {
                    basementPosition = i + 1;
                }
            }
        }

        _res1 = instructionFloor;
        _res2 = basementPosition;

        return this;
    }
}
