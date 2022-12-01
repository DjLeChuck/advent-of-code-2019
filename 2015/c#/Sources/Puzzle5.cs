using System;
using System.Text.RegularExpressions;

public class Puzzle5 : Puzzle {
    // Special thanks to DjLeChuck who helped me for the regex :)
    static readonly Regex regex11 = new Regex(@"(\w*[aeiou]\w*){3,}");
    static readonly Regex regex12 = new Regex(@"\w*(\w)\1\w*");
    static readonly Regex regex13 = new Regex(@"^((?!ab|cd|pq|xy)\w)*$");

    protected override byte _day { get { return 5; } }

    public override Puzzle Solve(string input) {
        var lines = input.SplitLines();
        _res1 = 0;

        for (int i = 0, len = lines.Length; i < len; i++) {
            var line = lines[i];

            if (regex11.Match(line).Success && regex12.Match(line).Success && regex13.Match(line).Success) {
                _res1++;
            }
        }

        return this;
    }
}
