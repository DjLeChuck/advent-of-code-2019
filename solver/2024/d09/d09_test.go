package main

import (
	"reflect"
	"testing"

	"github.com/djlechuck/advent-of-code/utils"
)

var (
	parsedInput = blocks{
		0, 0, ".", ".", ".", 1, 1, 1, ".", ".", ".",
		2, ".", ".", ".", 3, 3, 3, ".", 4, 4, ".", 5,
		5, 5, 5, ".", 6, 6, 6, 6, ".", 7, 7, 7, ".",
		8, 8, 8, 8, 9, 9,
	}
)

func TestProcessInput(t *testing.T) {
	in := utils.ParseInput("../../../inputs/2024/09_example.txt")
	e := processInput(in)

	if !reflect.DeepEqual(e, parsedInput) {
		t.Errorf("processInput(): got %v, want %v", e, parsedInput)
	}
}

func TestPartOne(t *testing.T) {
	expected := 1928

	result, _ := partOne(parsedInput)
	if result != expected {
		t.Errorf("partOne() = %d, want %d", result, expected)
	}
}

func TestPartTwo(t *testing.T) {
	expected := 0

	result, _ := partTwo()
	if result != expected {
		t.Errorf("partTwo() = %d, want %d", result, expected)
	}
}
