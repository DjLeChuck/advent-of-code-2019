package main

import (
	"reflect"
	"testing"

	"github.com/djlechuck/advent-of-code/utils"
)

var (
	parsedEquations = []equation{
		{190, []int{10, 19}},
		{3267, []int{81, 40, 27}},
		{83, []int{17, 5}},
		{156, []int{15, 6}},
		{7290, []int{6, 8, 6, 15}},
		{161011, []int{16, 10, 13}},
		{192, []int{17, 8, 14}},
		{21037, []int{9, 7, 18, 13}},
		{292, []int{11, 6, 16, 20}},
	}
)

func TestProcessInput(t *testing.T) {
	in := utils.ParseInput("../../../inputs/2024/07_example.txt")
	e := processInput(in)

	if !reflect.DeepEqual(e, parsedEquations) {
		t.Errorf("processInput(): got %v, want %v", e, parsedEquations)
	}
}

func TestPartOne(t *testing.T) {
	expected := 3749

	result, _ := partOne(parsedEquations)
	if result != expected {
		t.Errorf("partOne() = %d, want %d", result, expected)
	}
}

func TestPartTwo(t *testing.T) {
	expected := 11387

	result, _ := partTwo()
	if result != expected {
		t.Errorf("partTwo() = %d, want %d", result, expected)
	}
}
