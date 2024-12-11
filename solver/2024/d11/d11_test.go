package main

import (
	"reflect"
	"testing"

	"github.com/djlechuck/advent-of-code/utils"
)

var (
	parsedInput = field{125, 17}
)

func TestProcessInput(t *testing.T) {
	in := utils.ParseInput("../../../inputs/2024/11_example.txt")
	e := processInput(in)

	if !reflect.DeepEqual(e, parsedInput) {
		t.Errorf("processInput(): got %v, want %v", e, parsedInput)
	}
}

func TestPartOne(t *testing.T) {
	expected := 55312

	result, _ := partOne(parsedInput)
	if result != expected {
		t.Errorf("partOne() = %d, want %d", result, expected)
	}
}

func TestPartTwo(t *testing.T) {
	expected := 0

	result, _ := partTwo(parsedInput)
	if result != expected {
		t.Errorf("partTwo() = %d, want %d", result, expected)
	}
}
