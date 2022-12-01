using System;

public class Puzzle2 : Puzzle {
    const char DimensionSeparator = 'x';

    protected override byte _day { get { return 2; } }

    public override Puzzle Solve(string input) {
        var squareSize = 0;
        var ribbonSize = 0;

        var lines = input.SplitLines();

        for (int i = 0, len = lines.Length; i < len; i++) {
            var line = lines[i];
            var dimensions = line.Split(new char[] { DimensionSeparator }, 3);

            if (dimensions.Length == 3) {
                var dims = Array.ConvertAll(dimensions, int.Parse);
                Array.Sort(dims);

                var dim1 = dims[0];
                var dim2 = dims[1];
                var dim3 = dims[2];

                var side1 = dim1 * dim2;
                var side2 = dim2 * dim3;
                var side3 = dim3 * dim1;

                squareSize += 2 * side1 + 2 * side2 + 2 * side3 + side1;
                ribbonSize += 2 * dim1 + 2 * dim2 + dim1 * dim2 * dim3;
            }
        }

        _res1 = squareSize;
        _res2 = ribbonSize;

        return this;
    }
}
