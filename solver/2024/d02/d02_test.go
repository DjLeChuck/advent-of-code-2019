package main

import (
	"reflect"
	"testing"

	"github.com/djlechuck/advent-of-code/utils"
)

var (
	parsedInput = [][]int{
		{7, 6, 4, 2, 1},
		{1, 2, 7, 8, 9},
		{9, 7, 6, 2, 1},
		{1, 3, 2, 4, 5},
		{8, 6, 4, 4, 1},
		{1, 3, 6, 7, 9},
	}
)

func TestProcessInput(t *testing.T) {
	in := utils.ParseInput("../../../inputs/2024/02_example.txt")
	r := processInput(in)

	if !reflect.DeepEqual(r, parsedInput) {
		t.Errorf("parseInput(): got %v, want %v", r, parsedInput)
	}
}

func TestPartOne(t *testing.T) {
	expected := 2

	result, _ := partOne(parsedInput)
	if result != expected {
		t.Errorf("partOne() = %d, want %d", result, expected)
	}
}

func TestPartTwo(t *testing.T) {
	expected := 4

	result, _ := partTwo(parsedInput)
	if result != expected {
		t.Errorf("partTwo() = %d, want %d", result, expected)
	}
}
