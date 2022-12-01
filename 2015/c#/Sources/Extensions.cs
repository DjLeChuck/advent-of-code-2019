using System;
using System.Security.Cryptography;
using System.Text;

public static class Extensions {
    const string EndOfLine = "\r\n";

    public static string[] SplitLines(this string str) {
        return str.Split(new string[] { EndOfLine }, StringSplitOptions.RemoveEmptyEntries);
    }

    public static string md5(this string str) {
        var inputBytes = Encoding.ASCII.GetBytes(str);
        var md5 = MD5.Create();
        var hash = md5.ComputeHash(inputBytes);
        var sb = new StringBuilder();

        for (int i = 0, len = hash.Length; i < len; i++) {
            sb.Append(hash[i].ToString("x2"));
        }

        return sb.ToString();
    }
}
