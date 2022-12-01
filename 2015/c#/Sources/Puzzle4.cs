using System;

public class Puzzle4 : Puzzle {
    protected override byte _day { get { return 4; } }

    public override Puzzle Solve(string input) {
        var line = input.SplitLines()[0];

        _res1 = 0;
        while (!(line + _res1).md5().StartsWith("00000", StringComparison.Ordinal)) {
            _res1++;
        }

        Console.WriteLine(_res1.ToString());

        _res2 = _res1;
        while (!(line + _res2).md5().StartsWith("000000", StringComparison.Ordinal)) {
            _res2++;
        }

        return this;
    }
}
