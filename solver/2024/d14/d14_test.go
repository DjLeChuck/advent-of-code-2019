package main

import (
	"reflect"
	"testing"

	"github.com/djlechuck/advent-of-code/utils"
)

var (
	parsedInput = []*robot{
		{
			position{0, 4},
			velocity{3, -3},
		},
		{
			position{6, 3},
			velocity{-1, -3},
		},
		{
			position{10, 3},
			velocity{-1, 2},
		},
		{
			position{2, 0},
			velocity{2, -1},
		},
		{
			position{0, 0},
			velocity{1, 3},
		},
		{
			position{3, 0},
			velocity{-2, -2},
		},
		{
			position{7, 6},
			velocity{-1, -3},
		},
		{
			position{3, 0},
			velocity{-1, -2},
		},
		{
			position{9, 3},
			velocity{2, 3},
		},
		{
			position{7, 3},
			velocity{-1, 2},
		},
		{
			position{2, 4},
			velocity{2, -3},
		},
		{
			position{9, 5},
			velocity{-3, -3},
		},
	}
)

func TestProcessInput(t *testing.T) {
	in := utils.ParseInput("../../../inputs/2024/14_example.txt")
	e := processInput(in)

	if !reflect.DeepEqual(e, parsedInput) {
		t.Errorf("processInput(): got %v, want %v", e, parsedInput)
	}
}

func TestPartOne(t *testing.T) {
	expected := 12

	result, _ := partOne(parsedInput, grid{11, 7})
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
