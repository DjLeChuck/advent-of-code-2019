using System;
using System.Diagnostics;
using System.IO;
using System.Text;

public abstract class Puzzle {
    static readonly string _projectFolder = Path.GetDirectoryName(Path.GetDirectoryName(System.IO.Directory.GetCurrentDirectory()));

    protected int? _res1 = null;
    protected int? _res2 = null;

    protected abstract byte _day { get; }
    string _input { get { return File.ReadAllText(string.Format("{0}/Data/input{1}.txt", _projectFolder, _day)); } }

    public Puzzle Solve() {
        Solve(_input);
        return this;
    }

    public abstract Puzzle Solve(string input);

    public Puzzle Assert(int val1, int? val2 = null) {
        Debug.Assert(_res1 == val1);

        if (val2 != null) {
            Debug.Assert(_res2 == val2);
        }

        return this;
    }

    public Puzzle Check(string input, int? val1 = null, int? val2 = null) {
        Solve(input);

        if (val1 != null) {
            Debug.Assert(_res1 == val1);
        }

        if (val2 != null) {
            Debug.Assert(_res2 == val2);
        }

        return this;
    }

    public void Display() {
        var title = "Day " + _day;
        var underline = new String('-', title.Length);

        Console.WriteLine(new StringBuilder()
            .AppendLine(title)
            .AppendLine(underline)
            .AppendLine(_res1.ToString())
            .AppendLine(_res2.ToString())
            .ToString());
    }
}
