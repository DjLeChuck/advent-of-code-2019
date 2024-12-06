package main

import (
	"reflect"
	"testing"

	"github.com/djlechuck/advent-of-code/utils"
)

var (
	parsedInput = grid{
		coord{0, 0}: "M",
		coord{1, 0}: "M",
		coord{2, 0}: "M",
		coord{3, 0}: "S",
		coord{4, 0}: "X",
		coord{5, 0}: "X",
		coord{6, 0}: "M",
		coord{7, 0}: "A",
		coord{8, 0}: "S",
		coord{9, 0}: "M",
		coord{0, 1}: "M",
		coord{1, 1}: "S",
		coord{2, 1}: "A",
		coord{3, 1}: "M",
		coord{4, 1}: "X",
		coord{5, 1}: "M",
		coord{6, 1}: "S",
		coord{7, 1}: "M",
		coord{8, 1}: "S",
		coord{9, 1}: "A",
		coord{0, 2}: "A",
		coord{1, 2}: "M",
		coord{2, 2}: "X",
		coord{3, 2}: "S",
		coord{4, 2}: "X",
		coord{5, 2}: "M",
		coord{6, 2}: "A",
		coord{7, 2}: "A",
		coord{8, 2}: "M",
		coord{9, 2}: "M",
		coord{0, 3}: "M",
		coord{1, 3}: "S",
		coord{2, 3}: "A",
		coord{3, 3}: "M",
		coord{4, 3}: "A",
		coord{5, 3}: "S",
		coord{6, 3}: "M",
		coord{7, 3}: "S",
		coord{8, 3}: "M",
		coord{9, 3}: "X",
		coord{0, 4}: "X",
		coord{1, 4}: "M",
		coord{2, 4}: "A",
		coord{3, 4}: "S",
		coord{4, 4}: "A",
		coord{5, 4}: "M",
		coord{6, 4}: "X",
		coord{7, 4}: "A",
		coord{8, 4}: "M",
		coord{9, 4}: "M",
		coord{0, 5}: "X",
		coord{1, 5}: "X",
		coord{2, 5}: "A",
		coord{3, 5}: "M",
		coord{4, 5}: "M",
		coord{5, 5}: "X",
		coord{6, 5}: "X",
		coord{7, 5}: "A",
		coord{8, 5}: "M",
		coord{9, 5}: "A",
		coord{0, 6}: "S",
		coord{1, 6}: "M",
		coord{2, 6}: "S",
		coord{3, 6}: "M",
		coord{4, 6}: "S",
		coord{5, 6}: "A",
		coord{6, 6}: "S",
		coord{7, 6}: "X",
		coord{8, 6}: "S",
		coord{9, 6}: "S",
		coord{0, 7}: "S",
		coord{1, 7}: "A",
		coord{2, 7}: "X",
		coord{3, 7}: "A",
		coord{4, 7}: "M",
		coord{5, 7}: "A",
		coord{6, 7}: "S",
		coord{7, 7}: "A",
		coord{8, 7}: "A",
		coord{9, 7}: "A",
		coord{0, 8}: "M",
		coord{1, 8}: "A",
		coord{2, 8}: "M",
		coord{3, 8}: "M",
		coord{4, 8}: "M",
		coord{5, 8}: "X",
		coord{6, 8}: "M",
		coord{7, 8}: "M",
		coord{8, 8}: "M",
		coord{9, 8}: "M",
		coord{0, 9}: "M",
		coord{1, 9}: "X",
		coord{2, 9}: "M",
		coord{3, 9}: "X",
		coord{4, 9}: "A",
		coord{5, 9}: "X",
		coord{6, 9}: "M",
		coord{7, 9}: "A",
		coord{8, 9}: "S",
		coord{9, 9}: "X",
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
