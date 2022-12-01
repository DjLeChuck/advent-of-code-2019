using System;

public class Puzzle6 : Puzzle {
    const string TurnOn = "turn on";
    const string TurnOff = "turn off";
    const string Toggle = "toggle";
    const char WordSeparator = ' ';
    const char NumberSeparator = ',';
    const int GridSize = 1000;

    enum Action {
        TurnOn,
        TurnOff,
        Toggle
    }

    protected override byte _day { get { return 6; } }

    public override Puzzle Solve(string input) {
        var lines = input.SplitLines();
        var grid = new bool[GridSize, GridSize];

        for (int i = 0, len = lines.Length; i < len; i++) {
            var line = lines[i];
            var words = line.Split(new char[] { WordSeparator });

            var n1 = words[words.Length - 3];
            var n2 = words[words.Length - 1];
            var posArray1 = n1.Split(new char[] { NumberSeparator }, 2);
            var posArray2 = n2.Split(new char[] { NumberSeparator }, 2);
            var pos1 = Array.ConvertAll(posArray1, int.Parse);
            var pos2 = Array.ConvertAll(posArray2, int.Parse);

            Action action;

            if (line.StartsWith(TurnOn)) {
                action = Action.TurnOn;
            } else if (line.StartsWith(TurnOff)) {
                action = Action.TurnOff;
            } else if (line.StartsWith(Toggle)) {
                action = Action.Toggle;
            } else {
                break;
            }

            for (int dim1 = pos1[0]; dim1 <= pos2[0]; dim1++) {
                for (int dim2 = pos1[1]; dim2 <= pos2[1]; dim2++) {
                    if (action == Action.TurnOn) {
                        grid[dim1, dim2] = true;
                    } else if (action == Action.TurnOff) {
                        grid[dim1, dim2] = false;
                    } else {
                        grid[dim1, dim2] = !grid[dim1, dim2];
                    }
                }
            }
        }

        _res1 = 0;

        for (int dim1 = 0; dim1 < GridSize; dim1++) {
            for (int dim2 = 0; dim2 < GridSize; dim2++) {
                if (grid[dim1, dim2]) {
                    _res1++;
                }
            }
        }

        return this;
    }
}
