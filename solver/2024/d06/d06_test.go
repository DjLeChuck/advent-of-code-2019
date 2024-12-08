package main

import (
	"reflect"
	"testing"

	"github.com/djlechuck/advent-of-code/utils"
)

var (
	parsedGuard = guard{coord{4, 6}, "^"}
	parsedGrid  = grid{
		coord{0, 0}: ".",
		coord{0, 1}: ".",
		coord{0, 2}: ".",
		coord{0, 3}: ".",
		coord{0, 4}: ".",
		coord{0, 5}: ".",
		coord{0, 6}: ".",
		coord{0, 7}: ".",
		coord{0, 8}: "#",
		coord{0, 9}: ".",
		coord{1, 0}: ".",
		coord{1, 1}: ".",
		coord{1, 2}: ".",
		coord{1, 3}: ".",
		coord{1, 4}: ".",
		coord{1, 5}: ".",
		coord{1, 6}: "#",
		coord{1, 7}: ".",
		coord{1, 8}: ".",
		coord{1, 9}: ".",
		coord{2, 0}: ".",
		coord{2, 1}: ".",
		coord{2, 2}: ".",
		coord{2, 3}: "#",
		coord{2, 4}: ".",
		coord{2, 5}: ".",
		coord{2, 6}: ".",
		coord{2, 7}: ".",
		coord{2, 8}: ".",
		coord{2, 9}: ".",
		coord{3, 0}: ".",
		coord{3, 1}: ".",
		coord{3, 2}: ".",
		coord{3, 3}: ".",
		coord{3, 4}: ".",
		coord{3, 5}: ".",
		coord{3, 6}: ".",
		coord{3, 7}: ".",
		coord{3, 8}: ".",
		coord{3, 9}: ".",
		coord{4, 0}: "#",
		coord{4, 1}: ".",
		coord{4, 2}: ".",
		coord{4, 3}: ".",
		coord{4, 4}: ".",
		coord{4, 5}: ".",
		coord{4, 6}: ".",
		coord{4, 7}: ".",
		coord{4, 8}: ".",
		coord{4, 9}: ".",
		coord{5, 0}: ".",
		coord{5, 1}: ".",
		coord{5, 2}: ".",
		coord{5, 3}: ".",
		coord{5, 4}: ".",
		coord{5, 5}: ".",
		coord{5, 6}: ".",
		coord{5, 7}: ".",
		coord{5, 8}: ".",
		coord{5, 9}: ".",
		coord{6, 0}: ".",
		coord{6, 1}: ".",
		coord{6, 2}: ".",
		coord{6, 3}: ".",
		coord{6, 4}: ".",
		coord{6, 5}: ".",
		coord{6, 6}: ".",
		coord{6, 7}: ".",
		coord{6, 8}: ".",
		coord{6, 9}: "#",
		coord{7, 0}: ".",
		coord{7, 1}: ".",
		coord{7, 2}: ".",
		coord{7, 3}: ".",
		coord{7, 4}: "#",
		coord{7, 5}: ".",
		coord{7, 6}: ".",
		coord{7, 7}: ".",
		coord{7, 8}: ".",
		coord{7, 9}: ".",
		coord{8, 0}: ".",
		coord{8, 1}: ".",
		coord{8, 2}: ".",
		coord{8, 3}: ".",
		coord{8, 4}: ".",
		coord{8, 5}: ".",
		coord{8, 6}: ".",
		coord{8, 7}: "#",
		coord{8, 8}: ".",
		coord{8, 9}: ".",
		coord{9, 0}: ".",
		coord{9, 1}: "#",
		coord{9, 2}: ".",
		coord{9, 3}: ".",
		coord{9, 4}: ".",
		coord{9, 5}: ".",
		coord{9, 6}: ".",
		coord{9, 7}: ".",
		coord{9, 8}: ".",
		coord{9, 9}: ".",
	}
)

func TestProcessInput(t *testing.T) {
	in := utils.ParseInput("../../../inputs/2024/06_example.txt")
	gr, gu := processInput(in)

	if !reflect.DeepEqual(gr, parsedGrid) {
		t.Errorf("processInput() - gr: got %v, want %v", gr, parsedGrid)
	}
	if !reflect.DeepEqual(gu, parsedGuard) {
		t.Errorf("processInput() - gu: got %v, want %v", gu, parsedGuard)
	}
}

func TestPartOne(t *testing.T) {
	expected := 41

	result, _ := partOne(parsedGrid, parsedGuard)
	if result != expected {
		t.Errorf("partOne() = %d, want %d", result, expected)
	}
}

func TestPartTwo(t *testing.T) {
	expected := 6

	result, _ := partTwo(parsedGrid, parsedGuard)
	if result != expected {
		t.Errorf("partTwo() = %d, want %d", result, expected)
	}
}
