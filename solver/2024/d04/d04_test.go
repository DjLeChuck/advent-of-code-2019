package main

import (
	"reflect"
	"testing"

	"github.com/djlechuck/advent-of-code/utils"
)

var (
	parsedInput = Grid{
		Coord{0, 0}: "M",
		Coord{0, 1}: "M",
		Coord{0, 2}: "M",
		Coord{0, 3}: "S",
		Coord{0, 4}: "X",
		Coord{0, 5}: "X",
		Coord{0, 6}: "M",
		Coord{0, 7}: "A",
		Coord{0, 8}: "S",
		Coord{0, 9}: "M",
		Coord{1, 0}: "M",
		Coord{1, 1}: "S",
		Coord{1, 2}: "A",
		Coord{1, 3}: "M",
		Coord{1, 4}: "X",
		Coord{1, 5}: "M",
		Coord{1, 6}: "S",
		Coord{1, 7}: "M",
		Coord{1, 8}: "S",
		Coord{1, 9}: "A",
		Coord{2, 0}: "A",
		Coord{2, 1}: "M",
		Coord{2, 2}: "X",
		Coord{2, 3}: "S",
		Coord{2, 4}: "X",
		Coord{2, 5}: "M",
		Coord{2, 6}: "A",
		Coord{2, 7}: "A",
		Coord{2, 8}: "M",
		Coord{2, 9}: "M",
		Coord{3, 0}: "M",
		Coord{3, 1}: "S",
		Coord{3, 2}: "A",
		Coord{3, 3}: "M",
		Coord{3, 4}: "A",
		Coord{3, 5}: "S",
		Coord{3, 6}: "M",
		Coord{3, 7}: "S",
		Coord{3, 8}: "M",
		Coord{3, 9}: "X",
		Coord{4, 0}: "X",
		Coord{4, 1}: "M",
		Coord{4, 2}: "A",
		Coord{4, 3}: "S",
		Coord{4, 4}: "A",
		Coord{4, 5}: "M",
		Coord{4, 6}: "X",
		Coord{4, 7}: "A",
		Coord{4, 8}: "M",
		Coord{4, 9}: "M",
		Coord{5, 0}: "X",
		Coord{5, 1}: "X",
		Coord{5, 2}: "A",
		Coord{5, 3}: "M",
		Coord{5, 4}: "M",
		Coord{5, 5}: "X",
		Coord{5, 6}: "X",
		Coord{5, 7}: "A",
		Coord{5, 8}: "M",
		Coord{5, 9}: "A",
		Coord{6, 0}: "S",
		Coord{6, 1}: "M",
		Coord{6, 2}: "S",
		Coord{6, 3}: "M",
		Coord{6, 4}: "S",
		Coord{6, 5}: "A",
		Coord{6, 6}: "S",
		Coord{6, 7}: "X",
		Coord{6, 8}: "S",
		Coord{6, 9}: "S",
		Coord{7, 0}: "S",
		Coord{7, 1}: "A",
		Coord{7, 2}: "X",
		Coord{7, 3}: "A",
		Coord{7, 4}: "M",
		Coord{7, 5}: "A",
		Coord{7, 6}: "S",
		Coord{7, 7}: "A",
		Coord{7, 8}: "A",
		Coord{7, 9}: "A",
		Coord{8, 0}: "M",
		Coord{8, 1}: "A",
		Coord{8, 2}: "M",
		Coord{8, 3}: "M",
		Coord{8, 4}: "M",
		Coord{8, 5}: "X",
		Coord{8, 6}: "M",
		Coord{8, 7}: "M",
		Coord{8, 8}: "M",
		Coord{8, 9}: "M",
		Coord{9, 0}: "M",
		Coord{9, 1}: "X",
		Coord{9, 2}: "M",
		Coord{9, 3}: "X",
		Coord{9, 4}: "A",
		Coord{9, 5}: "X",
		Coord{9, 6}: "M",
		Coord{9, 7}: "A",
		Coord{9, 8}: "S",
		Coord{9, 9}: "X",
	}
)

func TestProcessInput(t *testing.T) {
	in := utils.ParseInput("../../../inputs/2024/04_example.txt")
	r := processInput(in)

	if !reflect.DeepEqual(r, parsedInput) {
		t.Errorf("processInput(): got %v, want %v", r, parsedInput)
	}
}

func TestPartOne(t *testing.T) {
	expected := 18

	result, _ := partOne(parsedInput)
	if result != expected {
		t.Errorf("partOne() = %d, want %d", result, expected)
	}
}

func TestPartTwo(t *testing.T) {
	expected := 9

	result, _ := partTwo(parsedInput)
	if result != expected {
		t.Errorf("partTwo() = %d, want %d", result, expected)
	}
}
