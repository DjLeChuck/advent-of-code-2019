package main

import (
	"fmt"
	"strconv"
	"strings"
	"time"

	"github.com/djlechuck/advent-of-code/utils"
)

type stone int64
type field []stone

func main() {
	in := utils.ParseInput("inputs/2024/11.txt")
	f := processInput(in)

	p1v, p1d := partOne(f)
	fmt.Printf("Part one: %d - elapsed: %s\n", p1v, p1d)
	p2v, p2d := partTwo(f)
	fmt.Printf("Part two: %d - elapsed: %s\n", p2v, p2d)
}

func processInput(in utils.Input) field {
	var f field

	for _, line := range in {
		parts := strings.Fields(line)

		for _, part := range parts {
			f = append(f, stone(utils.CastInt(part)))
		}
	}

	return f
}

func partOne(f field) (int, string) {
	t := time.Now()

	for i := 0; i < 25; i++ {
		f.blink()
	}

	return len(f), time.Since(t).String()
}

func partTwo(f field) (int, string) {
	t := time.Now()

	for i := 0; i < 75; i++ {
		fmt.Println(i)
		f.blink()
	}

	return len(f), time.Since(t).String()
}

func (f *field) blink() {
	for i := 0; i < len(*f); i++ {
		s := (*f)[i]

		if s == 0 {
			(*f)[i] = 1

			continue
		}

		if s.hasEvenDigits() {
			*f = append((*f)[:i], append(s.split(), (*f)[i+1:]...)...)
			i += 1

			continue
		}

		(*f)[i] *= 2024
	}
}

func (s *stone) hasEvenDigits() bool {
	i := int64(*s)
	if i == 0 {
		return false
	}
	count := 0
	for i != 0 {
		i /= 10
		count++
	}

	return count%2 == 0
}

func (s *stone) split() (ns []stone) {
	v := strconv.FormatInt(int64(*s), 10)
	m := len(v) / 2

	return []stone{stone(utils.CastInt(v[:m])), stone(utils.CastInt(v[m:]))}
}
