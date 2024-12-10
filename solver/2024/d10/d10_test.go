package main

import (
	"reflect"
	"testing"

	"github.com/djlechuck/advent-of-code/utils"
)

var (
	parsedInput = grid{
		points: gridPoints{
			{0, 0}: 8, coord{0, 1}: 7,
			{0, 2}: 8,
			{0, 3}: 9,
			{0, 4}: 4,
			{0, 5}: 3,
			{0, 6}: 0,
			{0, 7}: 1,
			{1, 0}: 9,
			{1, 1}: 8,
			{1, 2}: 7,
			{1, 3}: 6,
			{1, 4}: 5,
			{1, 5}: 2,
			{1, 6}: 1,
			{1, 7}: 0,
			{2, 0}: 0,
			{2, 1}: 1,
			{2, 2}: 4,
			{2, 3}: 5,
			{2, 4}: 6,
			{2, 5}: 0,
			{2, 6}: 3,
			{2, 7}: 4,
			{3, 0}: 1,
			{3, 1}: 2,
			{3, 2}: 3,
			{3, 3}: 4,
			{3, 4}: 7,
			{3, 5}: 1,
			{3, 6}: 2,
			{3, 7}: 5,
			{4, 0}: 0,
			{4, 1}: 1,
			{4, 2}: 0,
			{4, 3}: 9,
			{4, 4}: 8,
			{4, 5}: 9,
			{4, 6}: 9,
			{4, 7}: 6,
			{5, 0}: 1,
			{5, 1}: 8,
			{5, 2}: 9,
			{5, 3}: 8,
			{5, 4}: 9,
			{5, 5}: 0,
			{5, 6}: 8,
			{5, 7}: 7,
			{6, 0}: 2,
			{6, 1}: 7,
			{6, 2}: 6,
			{6, 3}: 7,
			{6, 4}: 0,
			{6, 5}: 1,
			{6, 6}: 0,
			{6, 7}: 3,
			{7, 0}: 3,
			{7, 1}: 4,
			{7, 2}: 5,
			{7, 3}: 4,
			{7, 4}: 3,
			{7, 5}: 2,
			{7, 6}: 1,
			{7, 7}: 2,
		},
		trailheads: []coord{
			{2, 0},
			{4, 0},
			{4, 2},
			{6, 4},
			{2, 5},
			{5, 5},
			{0, 6},
			{6, 6},
			{1, 7},
		},
	}
)

func TestProcessInput(t *testing.T) {
	in := utils.ParseInput("../../../inputs/2024/10_example.txt")
	e := processInput(in)

	if !reflect.DeepEqual(e, parsedInput) {
		t.Errorf("processInput(): got %v, want %v", e, parsedInput)
	}
}

func TestPartOne(t *testing.T) {
	expected := 36

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
